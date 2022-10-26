<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investmentplan extends Model
{
    //

    //protected $with = ['TransferMethod','Currency'];

    public function TransferMethod(){
    	return $this->belongsTo(\App\Models\TransferMethod::class);
    }

    public function Currency(){
    	return $this->belongsTo(\App\Models\Currency::class);
    }

    public function getMininvestmentAttribute($value){
		return (float)$value;    	
    }

    public function getMaxinvestmentAttribute($value){
		return (float)$value;    	
    }
}
