<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Voucher extends Model
{
    protected $fillable = ['user_id','voucher_amount','voucher_code','json_data','created_at','updated_at','currency_id','currency_symbol','user_loader','is_loaded','voucher_fee','wallet_id','voucher_value'];

    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }

    public function User(){
    	return $this->belongsTo(User::class);
    }

    public function Loader(){
    	return $this->belongsTo(User::class, 'user_loader');
    }

    public function LoaderName(){
    	if ($this->Loader) {
    		return $this->Loader->name;
    	}
    	return 'NAN';
    }

    public function value(){
        return $this->floattostr($this->voucher_value);
    	//return number_format((float)$this->voucher_value, 2, '.', ',') . ' '. $this->currency_symbol;
    }

    public function wasLoaded(){
    	if ($this->is_loaded) {
    		return 'Loaded';
    	}
    	return 'Unloaded';
    }

    private function floattostr( $val )
    {
        preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
        return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
    }
}
