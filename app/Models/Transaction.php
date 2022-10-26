<?php

namespace App\Models;

use App\User;
use Storage;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactionable';
    //protected $with = ['Status'];

    protected $fillable = [
        'user_id',
        'entity_id',
        'entity_name',
        'thumb',
        'currency',
        'balance',
        'activity_title',
        'money_flow',
        'transaction_state_id',
        'request_id',
        'gross',
        'fee',
        'net',
        'json_data',
        'currency_id',
        'is_cripto',
        'currency_symbol',
        'type',
        'wallet_address'
    ];


    public function Transactionable()
    {
        return $this->morph();
    }

    public function Currencie()
    {
        return $this->hasOne(\App\Models\Currency::class, 'id', 'currency_id');
    }

    public function Status()
    {
        return $this->hasOne(\App\Models\TransactionState::class, 'id', 'transaction_state_id');
    }

    public function User()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function gross()
    {
        if ($this->Currencie()->first()->is_crypto) {
            return $this->money_flow . ' ' .  $this->trimzero($this->gross) . ' ' . $this->currency_symbol;
        }

        return $this->money_flow . ' ' . number_format((float)$this->gross, 2, '.', ',') . ' ' .  $this->currency_symbol;
    }


    public function fee()
    {
        if ($this->fee > 0) {
            if ($this->Currencie()->first()->is_crypto) {
                return  '- ' . $this->trimzero($this->fee) . ' ' . $this->currency_symbol;
            }
            return  '- ' . number_format((float)$this->fee, 2, '.', ',') . ' ' . $this->currency_symbol;
        }

        if ($this->Currencie()->first()->is_crypto) {
            return   $this->trimzero($this->fee) . ' ' . $this->currency_symbol;
        }
        return number_format((float)$this->fee, 2, '.', ',') . ' ' . $this->currency_symbol;
    }

    public function net()
    {

        if ($this->Currencie()->first()->is_crypto) {
            return $this->money_flow . ' ' .  $this->trimzero($this->net) . ' ' . $this->currency_symbol;
        }

        return $this->money_flow . ' ' . number_format((float)$this->net, 2, '.', ',') . ' ' . $this->currency_symbol;
    }

    public function balance()
    {

        if ($this->Currencie()->first()->is_crypto) {
            return  $this->trimzero($this->balance) . ' ' . $this->currency_symbol;
        }

        return number_format((float)$this->balance, 2, '.', ',') . ' ' . $this->currency_symbol;
    }

    public function thumb()
    {
        return url('/') . '/' . $this->thumb;
    }

    private function trimzero($val)
    {
        preg_match("#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o);
        return $o[1] . sprintf('%d', $o[2]) . ($o[3] != '.' ? $o[3] : '');
    }
}
