<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['user_id','merchant_id', 'transaction_state_id', 'purchase_id','gross','fee', 'net','json_data','currency_id', 'currency_symbol'];


	public function User(){
		return $this->belongsTo(User::class);
	}

    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }
}
