<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = ['user_id','transaction_state_id','send_to_platform_name', 'platform_id', 'withdrawal_method_id','gross','fee','net','json_data','currency_id', 'currency_symbol','wallet_id', 'transfer_method_id', 'unique_transaction_id'];

    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }
    
    public function Method(){
    	return $this->hasOne(\App\Models\WithdrawalMethod::class, 'id', 'withdrawal_method_id');
    }

     public function transferMethod(){
        return $this->hasOne(\App\Models\TransferMethod::class, 'id', 'transfer_method_id');
    }

    public function Status(){
        return $this->hasOne(\App\Models\TransactionState::class, 'id', 'transaction_state_id');
    }
    public function gross(){
        return $this->money_flow .' '. number_format((float)$this->gross, 2, '.', '') .  $this->currency_symbol;
    } 


    public function fee(){
        if ($this->fee > 0) {
            return  '- ' . number_format((float)$this->fee, 2, '.', '') . $this->currency_symbol;
        }
        return number_format((float)$this->fee, 2, '.', '') . $this->currency_symbol;
    }

    public function net(){
         return $this->money_flow .' '. number_format((float)$this->net, 2, '.', '') .  $this->currency_symbol;
    }
}
