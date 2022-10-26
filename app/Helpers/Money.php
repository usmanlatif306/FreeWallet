<?php

namespace App\Helpers;

use Auth;

class Money
{
    public function value($val,  $currency_symbol = null)
    {
      if (!is_null($currency_symbol) and  $currency_symbol == '(BTC)') {
     		return $this->trimzero($val) .' '. $currency_symbol;
      }
       return  number_format((float)$val, 2, '.', ',') . ' '. $currency_symbol;
    }
    
    public static function instance()
    {

       return new Money();
    }

    private function trimzero( $val )
    {
        preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
        return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
    }
}