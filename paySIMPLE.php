<?php

    $amount = $_POST["amount"];
    $paidCurrency = $_POST["currency"];
    $callback_url = $_POST["callback_url"];
    $success_url = $_POST["success_url"];
    $fail_url = $_POST["fail_url"];

    require './B2BInPaySandbox.php';

    $b2bInPaySandbox = new B2BInPaySandbox();

    $responseJson = $b2bInPaySandbox->createBill($amount,$paidCurrency,$callback_url,$success_url,$fail_url,$order_id);
    
    $paymentUrl = json_decode($responseJson)->data->url;

    header("Location: ".$paymentUrl);