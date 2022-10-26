<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyWithdrawalMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('currency_withdrawal_methods', function (Blueprint $table) {

    		$table->id();
    		$table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
    		$table->unsignedBigInteger('withdrawal_method_id');
             $table->foreign('withdrawal_method_id')->references('id')->on('withdrawal_methods')->onDelete('cascade')->onUpdate('cascade');
    		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('currency_withdrawal_methods');
    }
}