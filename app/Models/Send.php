<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Send extends Model
{	
	protected $with = ['User', 'To'];
    protected $fillable = ['user_id', 'to_id', 'receive_id', 'transaction_state_id', 'gross', 'fee', 'net', 'description', 'json_data','currency_id', 'currency_symbol'];

    public function User(){
    	return $this->belongsTo(\App\User::class);
    }

    public function To(){
    	return $this->belongsTo(\App\User::class, 'to_id');
    }

    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }
}
