<?php

$data = array("content" => "Your Content", "username" => "Webhooks");
$curl = curl_init("https://hdigiplay.com/b2binpay/callback.php");
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_error($curl);
$res = curl_exec($curl);

echo($res);