<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
	//protected $with =	['Method','Status'];
    protected $fillable = ['user_id', 'first_currency_id', 'second_currency_id',  'gross', 'fee', 'net'];

    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }
    
    public function gross(){
        return $this->money_flow .' '. number_format((float)$this->gross, 2, '.', '') .  $this->currency_symbol;
    } 

    public function fee(){
        if ($this->fee > 0) {
            return  '- ' . number_format((float)$this->fee, 2, '.', '') . $this->currency_symbol;
        }
        return number_format((float)$this->fee, 2, '.', '') . $this->currency_symbol;
    }

    public function net(){
         return $this->money_flow .' '. number_format((float)$this->net, 2, '.', '') .  $this->currency_symbol;
    }
}