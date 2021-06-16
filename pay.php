<?php

    if(!isset($_POST["amount"])||!isset($_POST["currency"])||!is_numeric($_POST["amount"])){
        echo '<h1>Please Send Amount and Currency</h1>';
        exit();
    }

    ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set ("Europe/Madrid");
        $paymentDate=date('Y-m-d H:i:s');
        $ip=$_SERVER['REMOTE_ADDR'];
        $count_row = rand(1,9999);
        $amount = $_POST['amount'];
        require("db_connect.php");
        $invoice = $order_id =  unique_pin();
        $paidCurrency = $_POST["currency"];
        $currencies = array("1"=>"BTC","2"=>"ETH","3"=>"USDTC (OMNI)","4"=>"USDTC (ETH)");
        $paidCurrencyX = $currencies[$paidCurrency];
        if(isset($_POST['transaction_id']) && !empty($_POST['transaction_id'])){  
            
            $first_name = $firstname = mysqli_real_escape_string($conn,$_POST["first_name"]); 
            $last_name = $lastname = mysqli_real_escape_string($conn,$_POST["last_name"]); 
            $fullName = mysqli_real_escape_string($conn,$firstname." ".$lastname);
            $custName         = strtoupper($fullName);
            $email=mysqli_real_escape_string($conn,$_POST["email"]);

            $credit_card_number=$expiry_month=$expiry_year=$cvv="";
            $amount1=$amount;
            $address1 = $address= mysqli_real_escape_string($conn,$_POST['billAddress']);
            $zip = mysqli_real_escape_string($conn,$_POST['billZip']);
            $callback_url= "https://hdigiplay.com/b2binpay/callback.php";
            $success_url= "https://hdigiplay.com/b2binpay/success.php"; 
            $fail_url= "https://hdigiplay.com/b2binpay/declined.php"; 
            $redirect_url = "";
            $g_type = "B2BInPay";
            $zipcode = $zip;
            $phone = mysqli_real_escape_string($conn,$_POST['phoneNum']);
            $country          = mysqli_real_escape_string($conn,$_POST['billCountry']);
            $state = mysqli_real_escape_string($conn,$_POST['billState']);
            $city = mysqli_real_escape_string($conn,$_POST['billCity']);
            $ipn = mysqli_real_escape_string($conn,$_POST['ipn']);
            $transaction_id = $_POST['transaction_id'];


            $orderdescription = "";
            $ccnumber = "";//mysqli_real_escape_string($conn,$credit_card_number);
            $ccexp ="";// mysqli_real_escape_string($conn,$expiry_month.'/'.$expiry_year);
            $ip= $ipaddress  =   $_SERVER['REMOTE_ADDR'];

            /****************************Checking**********************************/
            require_once("gatewayRules.php");
            /**********************************************************************/ 
                        
            $sql = "INSERT INTO  t_master_sales ( 
            ipn_no, 
            client_transaction_id,  
            order_id, 
            customer_name,  
            customer_email, 
            customer_address,
            customer_city,
            customer_state,
            customer_country,
            customer_zip,
            customer_phone, 
            item_name,
            item_number,
            item_price,
            item_price_currency,
            grossPrice,
            currency_type,
            card_no,
            cvv,
            card_expiry,
            ip,
            g_type, 
            status,
            rec_crt_date,
            rec_up_date,
            callback_url,
            success_url,
            fail_url)
                VALUES (
                '".addslashes($ipn)."',
                '".addslashes($transaction_id)."',
                '".addslashes($order_id)."',
                '".addslashes($custName)."',
                '".addslashes($email)."',
                '".addslashes($address1)."',
                '".addslashes($city)."',
                '".addslashes($state)."',
                '".addslashes($country)."',
                '".addslashes($zip)."',
                '".addslashes($phone)."',
                '".$orderdescription."',
                '".$orderdescription."',
                '".$amount."',
                '".$paidCurrencyX."',
                '".$amount1."',
                '".$paidCurrencyX."',
                '".$ccnumber."',
                '".$cvv."',
                '".$ccexp."',
                '".$ipaddress."',
                '".$g_type."',    
                '".addslashes('Process')."',
                '".addslashes(date('y-m-d H:i:s'))."',
                '".addslashes(date('y-m-d H:i:s'))."',
                '".addslashes($callback_url)."',
                '".addslashes($success_url)."',
                '".addslashes($fail_url)."'
                )";

            mysqli_query($conn, $sql);


        }   

        require './B2BInPaySandbox.php';

        $b2bInPaySandbox = new B2BInPaySandbox();


        $responseJson = $b2bInPaySandbox->createBill($amount,$paidCurrency,$callback_url,$success_url,$fail_url,$order_id);
        
        $paymentUrl = json_decode($responseJson)->data->url;
        
        require("./Cache.php");
        $cache = new Cache();
        
        $cache->set("txId_".$order_id,$transaction_id);

        echo($paymentUrl);