<?php

namespace App\Models;

use App\User;
use App\Models\TransferMethod;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
	protected $fillable = ['user_id', 'amount', 'currency_id', 'is_crypto', 'crypto', 'fiat', 'transfer_method_id', 'accont_identifier_mechanism_value', 'blockio_address'];

	public function User()
	{
		return $this->belongsTo(User::class);
	}

	public function Currency()
	{
		return $this->belongsTo(Currency::class);
	}

	public function TransferMethod()
	{
		return $this->belongsTo(TransferMethod::class);
	}

	public function TransferMethods()
	{
		return $this->belongsToMany(TransferMethod::class, 'transfer_method_wallet', 'wallet_id', 'transfer_method_id')->withTimestamps()->withPivot(['user_id', 'adress']);
	}

	public function setAmountAttribute($value)
	{

		if ($this->attributes['is_crypto'] == 1) {

			$this->attributes['crypto'] = $value;

			return true;
		}

		$this->attributes['fiat'] = $value;

		return true;
	}

	public function getAmountAttribute($value)
	{

		if ($this->attributes['is_crypto'] == 1) {

			return $this->attributes['crypto'];
		}

		return $this->attributes['fiat'];
	}
}
