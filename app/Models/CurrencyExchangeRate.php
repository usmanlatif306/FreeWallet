<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyExchangeRate extends Model
{
	protected $fillable = ['first_currency_id', 'second_currency_id', 'exchanges_to_second_currency_value'];

	public function firstCurrency()
	{

		return $this->belongsTo(Currency::class, 'first_currency_id');
	}

	public function secondCurrency()
	{

		return $this->belongsTo(Currency::class, 'second_currency_id');
	}
}
