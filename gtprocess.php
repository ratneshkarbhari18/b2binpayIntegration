<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


$first_name=$_POST['first_name']; 
$last_name=$_POST['last_name']; 
$email=$_POST['email']; 
$phoneNum=$_POST['contact']; 
$billAddress=$_POST['address']; 
$address1=$_POST['address1']; 
$billCountry=$_POST['country']; 
$billState=$_POST['state']; 
$billCity=$_POST['city']; 
$billZip=$_POST['zip']; 
$amount=$_POST['amount'];

$card_no="";
$exp_year="";
$exp_month="";
$cvv="";
$currency=$_POST['currency'];
$transaction_id = time();
$callback_url = $_POST['callback_url'];
$success_url = $_POST['callback_url'];
$fail_url = $_POST['callback_url'];
$ipn='TEST1234';
//$ipn='SBDPG3373750780196';
$url=$_POST['url'];
//print_r($_POST);
  $postdata="transaction_id=".$transaction_id."&currency=".$currency."&ccnumber=".$card_no."&ccexpyr=".$exp_year."&ccexpmon=".$exp_month."&cvv=".$cvv."&amount=".$amount."&email=".$email."&first_name=".$first_name."&last_name=".$last_name."&phoneNum=".$phoneNum."&billCountry=".$billCountry."&billState=".$billState."&billCity=".$billCity."&billAddress=".$billAddress."&billZip=".$billZip."&ipn=".$ipn."&callback_url=".$callback_url."&redirect_url=".$success_url."&exp_month=".$exp_month."&cvv=".$cvv."&card_no=".$card_no."&exp_year=".$exp_year;

/*
$ch = curl_init(); 
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
//curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)");
curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt ($ch, CURLOPT_REFERER, $url); 
curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
curl_setopt ($ch, CURLOPT_POST, true); 
$result = curl_exec ($ch); 
echo $result;
curl_close($ch);
*/


$ch = curl_init(); 
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, true); 
//curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)");
curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0); 
//curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); 
//curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
curl_setopt ($ch, CURLOPT_REFERER, $url); 
curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
curl_setopt ($ch, CURLOPT_POST, true); 
$result = curl_exec ($ch);
echo curl_error($ch);


curl_close($ch);


if ($url=="https://hdigiplay.com/b2binpay/pay.php") {

  header("Location: ".$result);

}