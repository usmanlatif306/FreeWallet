<?php

namespace App\Models;

use Storage;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;

class DepositMethod extends Model
{

	protected $fillable = ['name','how_to','json_data','thumb','created_at','updated_at'];
    
    public function getThumbAttribute($value){
    	if ($value) {
    		return $value;
    	}

    	return Storage::url('users/default.png');
    }

    public function currencies(){
    	return $this->belongsToMany(Currency::class , 'currency_deposit_methods' );
    }

}
