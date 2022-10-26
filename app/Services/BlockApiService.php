<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;


class BlockApiService
{

    public $block_io;
    public $params;

    public function __construct()
    {
        $this->params['api_key'] = env('BLOCK_API_KEY');
    }
    // get overall balance
    public function getBalance()
    {
        $response = $this->curl_request('get_balance');
        if ($response->status === 'success') {
            return $response->data->available_balance;
        }
    }

    // create new wallet
    public function createWallet($name)
    {
        $this->params['label'] = $name;
        $response = $this->curl_request('get_new_address');
        if ($response->status === 'success') {
            return $response->data->address;
        } else {
            throw new Exception($response->data->error_message);
        }
    }

    // get Address balance
    public function getAddressBalance($address)
    {
        $this->params['addresses'] = $address;
        $response = $this->curl_request('get_address_balance');
        if ($response->status === 'success') {
            dd($response);
            return $response->data->available_balance;
        } else {
            throw new Exception($response->data->error_message);
        }
    }

    // sending balance to another balance
    public function transaction($amount, $from_address, $to_address)
    {
        // $transaction = $this->block_io->prepare_transaction(array('amounts' => $amount, 'from_addresses' => $from_address, 'to_addresses' => $to_address));
        // $response = $this->create_and_sign_transaction($transaction);

        // return $response;

        $this->params['amounts'] = $amount;
        $this->params['from_addresses'] = $from_address;
        $this->params['to_addresses'] = $to_address;
        $response = $this->curl_request('prepare_transaction');

        dd($response);
    }

    // create_and_sign_transaction
    private function create_and_sign_transaction($api_response)
    {
        $transaction = $this->block_io->create_and_sign_transaction($api_response);

        $response =  $this->block_io->submit_transaction(array('transaction_data' => $transaction));

        return $response;
    }

    // get transactions
    public function getTransaction($type = "received", $address)
    {
        $transactions = $this->block_io->get_transactions(array('type' => $type, 'addresses' => $address));

        return $transactions->data->txs;
    }

    // get current price
    public function getCuurenctPrice($type = Null)
    {
        if (!$type) {
            $query = $this->block_io->get_current_price();
        } else {
            $query = $this->block_io->get_current_price(array('price_base' => $type));
        }

        return $query->data->prices;
    }



    // curl request
    public function curl_request($method)
    {
        $version = env('BLOCK_API_VERSION');
        $query = http_build_query($this->params);

        $url = "https://block.io/api/v$version/$method/?$query";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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

        return $response;
    }
}
