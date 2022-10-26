<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Escrow extends Model
{

    protected $fillable = ['user_id', 'to', 'gross', 'description','json_data','currency_id','currency_symbol','escrow_transaction_status','deleted_at','created_at','updated_at', 'agreement'];


    public function User(){
    	return $this->belongsTo(User::class);
    }

    public function toUser(){
    	return $this->belongsTo(User::class, 'to');
    }

    

}
