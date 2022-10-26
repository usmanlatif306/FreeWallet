<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = ['user_id','investmentplan_id','capital','earnings','is_crypto','start','end','status','deleted_at','created_at','updated_at'];

    public function User(){
    	return $this->belonsTo(\App\User::class);
    }

    public function Plan(){
    	return $this->belongsTo(\App\Models\Investmentplan::class, 'investmentplan_id');
    }

    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }
}
