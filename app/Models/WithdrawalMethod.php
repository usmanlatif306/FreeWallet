<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;

class WithdrawalMethod extends Model
{
    
    protected $fillable = ['name','percentage_fee','fixed_fee','json_data','created_at','updated_at','thumb'];
    
    public function getThumbAttribute($value){
    	if ($value) {
    		return $value;
    	}

    	return Storage::url('users/default.png');
    }
}
