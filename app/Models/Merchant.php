<?php

namespace App\Models;
use App\User;
use Storage;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected  $fillable =['user_id', 'thumb', 'name', 'site_url', 'success_link', 'fail_link', 'logo', 'description','json_data','merchant_key','currency_id', 'ipn_url'];

    public function User(){
    	return $this->belongsTo(User::class);
    }
    public function Currency(){
    	return $this->belongsTo(Currency::class);
    }

    public function getLogoAttribute($value){
    	if( $value ) return $value ;

    	return Storage::url('users/default.png') ; 
    }
}
