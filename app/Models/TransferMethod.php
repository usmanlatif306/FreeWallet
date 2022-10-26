<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferMethod extends Model
{

    protected $fillable = [
        'currency_id',
        'name',
        'accont_identifier_mechanism',
        'how_to_deposit',
        'how_to_withdraw',
        'days_to_process_transfer',
        'is_active',
        'thumbnail',
        'deposit_percentage_fee',
        'deposit_fixed_fee',
        'withdraw_percentage_fee',
        'withdraw_fixed_fee',
        'mobile_thumbnail',
        'merchant_percentage_fee',
        'merchant_fixed_fee'


    ];

    public function currency(){
        return $this->belongsTo(\App\Models\Currency::class);
    }
}
