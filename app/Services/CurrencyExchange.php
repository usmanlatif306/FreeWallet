<?php

namespace App\Services;


class CurrencyExchange
{
    public function convertCurrency($to = 'usd', $from = 'pkr', $amount = 100)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=$to&from=$from&amount=$amount",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: XW8BzKwm4AiwmuOLykeYXNTlNrFmGmRK"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        return $response->result;
    }

    // getBitcoinPrice
    public function getPrice($convert = 'USD')
    {
        // https://sandbox-api.coinmarketcap.com
        // https://pro-api.coinmarketcap.com
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
        $parameters = [
            "symbol" => "BTC",
            "convert" => $convert
        ];
        // 'start' => '1',
        //     'limit' => '5',

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: 70f41002-cd0d-46cc-aea6-40443d6f2e7e'
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers 
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        $response = json_decode($response);
        curl_close($curl); // Close request
        return $response->data->BTC->quote->$convert->price;
        // return $response->data[0]->quote->$convert->price;
    }
}
