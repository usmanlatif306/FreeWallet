<?php

namespace App\Services;

use Illuminate\Http\Request;


class BlockApiService
{

    public $block_io;

    public function __construct()
    {
        $apiKey = env('BLOCK_API_KEY');
        $version = env('BLOCK_API_VERSION');
        $pin = env('BLOCK_API_PIN');
        // $this->blockApi = new BlockIo($apiKey, $pin, $version);
        $this->block_io = new \BlockIo\Client($apiKey, $pin, $version);
        return $this->block_io;
    }
    // get overall balance
    public function getBalance()
    {
        $balance = $this->block_io->get_balance();
        dd($balance);
    }

    // create new wallet
    public function createWallet($name)
    {
        $newWallet = $this->block_io->get_new_address(array('label' => $name));

        return $newWallet->data->address;
    }

    // get Address balance
    public function getAddressBalance($address)
    {
        $balance = $this->block_io->get_address_balance(array('addresses' => $address));

        return $balance->data->available_balance;
    }

    // sending balance to another balance
    public function Transaction($amount, $from_address, $to_address)
    {
        $transaction = $this->block_io->prepare_transaction(array('amounts' => $amount, 'from_addresses' => $from_address, 'to_addresses' => $to_address));
        $response = $this->create_and_sign_transaction($transaction);

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

    // create_and_sign_transaction
    private function create_and_sign_transaction($api_response)
    {
        $transaction = $this->block_io->create_and_sign_transaction($api_response);

        $response =  $this->block_io->submit_transaction(array('transaction_data' => $$transaction));

        return $response;
    }
}
