<?php

    class B2BInPaySandbox{
        
        private $key = "bf37cb5fe8";
        private $secret = "25372606ee0d3c8";

        private $defaultCoin = "BTC";
        private $defaultwalletId = 765;
        private $defaultWalletDomain = "https://cr-test.b2binpay.com";
        
        private $virtualWalletDomain = "https://gw-test.b2binpay.com";
        private $virtualWalletId = 275;
        

        private $currencies = array("1"=>765,"2"=>766,"3"=>767,"4"=>768);

        private function getToken(){

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://cr-test.b2binpay.com/api/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic '.base64_encode($this->key.':'.$this->secret)
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response,TRUE)["access_token"];


        }
        
        public function createBill($amount,$paidCurrency,$callback_url,$success_url,$fail_url,$order_id){

            $token = $this->getToken();

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://cr-test.b2binpay.com/api/v1/pay/bills',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'amount' => $amount,
                'wallet' => $this->currencies[$paidCurrency],
                'callback_url' => $callback_url,
                'tracking_id' => $order_id,
                "success_url" => $success_url,
                "error_url" => $fail_url
            ),
            CURLOPT_HTTPHEADER => array(
                'authorization: Bearer '.$token
            ),
            ));

            return $response = curl_exec($curl);

            curl_close($curl);

        }

    }
    