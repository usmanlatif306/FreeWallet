<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
	protected $fillable = ['name', 'symbol', 'created_aat', 'updated_at' , 'code', 'is_cripto','thumb'];

	public function getThumbAttribute($value){
		
		if( $value == null )
		{ 
			return Storage::url('users/default.png'); 
		} 
		
		return $value;
	}

	public function DepositMethods(){
		return $this->belongsToMany(\App\Models\DepositMethod::class, 'currency_deposit_methods');
	}

	public function WithdrawalMethods(){
		return $this->belongsToMany(\App\Models\WithdrawalMethod::class, 'currency_withdrawal_methods');
	}
}