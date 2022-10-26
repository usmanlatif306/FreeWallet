<?php

namespace App\Services;

use Illuminate\Http\Request;


class IdentityService
{
    public function getToken()
    {
        $curl = curl_init();
        $data = '{"client_id":"b6fe9100-ed3c-11ec-a3fd-a19b9cb895a3","email":"hammad@xorexs.com"}';
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://app.faceki.com/getToken",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);
        // dd($response);
        return $response->token;
    }

    // identification
    public function identification($token, $data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://app.faceki.com/kyc-verification",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: multipart/form-data",
                "Authorization: Bearer " . $token,
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);
        return $response;
    }
}
