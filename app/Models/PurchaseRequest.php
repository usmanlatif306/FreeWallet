<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $table = 'requests';

    protected $fillable = ['merchant_key','ref','data', 'is_expired', 'currency_code', 'currency_id'];

    public function getDataAttribute($value){
    	return json_decode($value);
    }

    public function Transaction(){
        return $this->hasOne(Transaction::class, 'request_id');
    }

    public function Currency(){
        return $this->belongsTo(Currency::class);
    }

}