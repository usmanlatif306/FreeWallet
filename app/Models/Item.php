<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['user_id', 'price',  'description', 'name', 'merchant_id', 'thumbnail', 'code',' currency_id', 'link' ];


    public function Currency(){
    	return $this->hasOne(\App\Models\Currency::class, 'id', 'currency_id');
    }

    public function User(){
    	return $this->belongsTo(\App\ser::class);
    }
     public function getUpdatedAtAttribute(  $date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');//->diffForHumans() ;//\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function getCreatedAtAttribute(  $date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');//->diffForHumans() ;//\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
}
