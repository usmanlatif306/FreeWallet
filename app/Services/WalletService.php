<?php

namespace App\Services;

class WalletService
{
    // create wallet
    public function createWallet()
    {
        $data = array(
            'port' => env('WALLET_PORT'),
            "password" => "Pakistan@0014",
            "api_code" => env('BLOCKCHAIN_API_CODE'),
            "label" => "Usman Latif",
            "email" => "usmanlatif603@gmail.com",
        );
        $response = $this->curl("create_wallet", $data);
        dd($response);
    }

    // get balance
    public function balance()
    {
        $data = array(
            'port' => env('WALLET_PORT'),
            "password" => "Pakistan@0014",
            "api_code" => env('BLOCKCHAIN_API_CODE'),
            "guid" => "fb004ea4-21e0-4abd-8e14-76ca84ae503f"
        );
        $response = $this->curl("balance", $data);
        dd($response);
    }

    // get address balance
    public function address_balance()
    {
        $data = array(
            'port' => env('WALLET_PORT'),
            "password" => "Pakistan@0014",
            "api_code" => env('BLOCKCHAIN_API_CODE'),
            "guid" => "fb004ea4-21e0-4abd-8e14-76ca84ae503f",
            "address" => "1PvtBQit1spDxFmCuF4vQmLLKjTPDR275n"
        );
        $response = $this->curl("address_balance", $data);
        dd($response);
    }

    // send money
    public function send_money()
    {
        $data = array(
            'port' => env('WALLET_PORT'),
            "password" => "Pakistan@0014",
            "api_code" => env('BLOCKCHAIN_API_CODE'),
            "guid" => "fb004ea4-21e0-4abd-8e14-76ca84ae503f",
            "address" => "1PvtBQit1spDxFmCuF4vQmLLKjTPDR275n",
            "amount" => 0
        );
        $response = $this->curl("send_money", $data);
        dd($response);
    }

    // curl request
    private function curl($url, $data = [])
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('WALLET_ADDRESS') . $url . ".php",
            CURLOPT_HTTPHEADER => array(
                "Content-Type:application/json",
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data)
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }
}
