<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['user_id', 'price', ' currency_id', 'description', 'name', 'merchant_id', 'thumbnail',  ];


    public function Currency(){
    	return $this->belongsTo(App\Models\Currency::class);
    }

    public function User(){
    	return $this->belongsTo(App\User::class);
    }
}
