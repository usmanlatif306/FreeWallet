<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyExchangeRatesTable extends Migration
{
    public function up()
    {
        Schema::create('currency_exchange_rates', function (Blueprint $table) {
    		$table->id();
    		$table->unsignedBigInteger('first_currency_id');
             $table->foreign('first_currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
    		$table->unsignedBigInteger('second_currency_id');
             $table->foreign('second_currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
    		$table->decimal('exchanges_to_second_currency_value', 18 , 9)->nullable()->default(NULL);
    		$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('currency_exchange_rates');
    }
}