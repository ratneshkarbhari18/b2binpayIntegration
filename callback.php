<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    // $responseJson = file_get_contents("php://input");
    
    $responseJson = json_encode($_POST);

    // $responseJson = '{
    //     "id": 11673,
    //     "url": "https://gw-test.b2binpay.com/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJCMkJDcnlwdG9QYXkiLCJzdWIiOjExNjczLCJpYXQiOjE1ODAyOTI3MTgsImV4cCI6MTU4MDM3OTExOH0.3XtdxiRNfrDLLQCAX2HHEUmw1bo9CS5-wv8KtYHlGR0",
    //     "address": "5e315a6e23e7e2a084e55c87b14bcdaad1f62fdbbac8e",
    //     "created": "2020-01-29 10:11:58",
    //     "expired": "2020-01-30 10:11:58",
    //     "status": "2",
    //     "tracking_id": "2",
    //     "callback_url": "https://your.website.com/b2binpay/callback",
    //     "amount": "500000000000000000",
    //     "actual_amount": "500000000000000000",
    //     "pow": "18",
    //     "transactions": [
    //       {
    //         "id": "9742",
    //         "bill_id": "11673",
    //         "created": "2020-01-29 10:15:02",
    //         "amount": "500000000000000000",
    //         "pow": "18",
    //         "status": "1",
    //         "transaction": "NWUzMTVhNmUyM2U3ZTJhMDg0ZgU1Yzg3YjFlYmNkYWFkMWY2MmZkYmJhYzhlIzAuNTAwMDAwMDAwMDAwMDAwMDAw",
    //         "type": "0",
    //         "currency": {
    //           "iso": "1000",
    //           "alpha": "BTC"
    //         },
    //         "transfer_amount": "439617",
    //         "transfer_pow": "2",
    //         "transfer_currency": {
    //           "iso": "840",
    //           "alpha": "USD"
    //         },
    //         "transfer_rate": "883652509337",
    //         "transfer_rate_pow": "8"
    //       }
    //     ],
    //     "currency": {
    //       "iso": "1000",
    //       "alpha": "BTC"
    //     },
    //     "sign": 
    //     {
    //       "time": "Wed Jan 29 2020 10:15:06 GMT+0000",
    //       "hash": "{HASH}"
    //     }
    // }';    


// file_get_contents("https://codesevaco.tech/assets/recordrespose.php?response=".$responseJson);

$responseObj = json_decode($responseJson);

require './db_connect.php';



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("db_connect.php");
date_default_timezone_set ("Europe/Madrid");

require './Cache.php';
$cache = new Cache();

$responseObj = json_decode($responseJson,TRUE);
$orderid = $responseObj["tracking_id"];
$statusCode = $responseObj["status"];

if ($statusCode==2) {
    $status="Success";
    $rCode = $statusCode." Success";
} else {
    $status="Declined";
    $rCode= $statusCode." Declined";
}

$transaction_id = $cache->get("txId_".$orderid);


$sql = "SELECT id,client_transaction_id,grossPrice,currency_type,callback_url,success_url FROM  t_master_sales where client_transaction_id='".$transaction_id."' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        //$id=$row["id"];
        $client_transaction_id=$row["client_transaction_id"];
        $grossPrice=$row["grossPrice"];
        $grossPrice=$row["currency_type"];
        $postback_url=$row["callback_url"];
    }
}

$gwTxId = $responseObj["id"];

$updateTransactionSQL = "UPDATE t_master_sales SET gatewayTransactionId='".$gwTxId."',order_id='".$orderid."',response = '".$response."', response_code = '".$rCode."', status='".$status."', rec_up_date='".date('Y-m-d H:i:s')."' WHERE client_transaction_id='".$transaction_id."' ORDER BY id DESC LIMIT 1";
    
$updated = mysqli_query($conn, $updateTransactionSQL) or die("database error: ". mysqli_error($conn));

if ($updated) {

    $arr=array('transaction_id'=>$transaction_id,'status'=>$status,'paid_amount'=>$grossPrice,'response'=>$response);


    $data =  http_build_query($arr);
    $curl = curl_init($postback_url);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl,CURLOPT_HEADER, 0 ); // Colate HTTP header
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// Show the outputz
    curl_setopt($curl,CURLOPT_POST,true); // Transmit datas by using POST
    curl_setopt($curl,CURLOPT_POSTFIELDS,$data);//Transmit datas by using POST
    //curl_setopt($curl,CURLOPT_REFERER,$returnUrl);
    $xmlrs = curl_exec($curl); 
    // echo "Executed";
    
    
    // response log query  
    $sqlResponse = "INSERT INTO response_log ( 
        transaction_id,	
        response,	
        rec_crt_date
        )VALUES (
            '".addslashes($transaction_id)."',
            '".addslashes($xmlrs)."',
            '".addslashes(date('y-m-d H:i:s'))."'
            )";
    mysqli_query($conn, $sqlResponse);
   //replace here
    curl_close ($curl);
    // exit();
} else 
{
    echo mysqli_error($conn);
}
?>

