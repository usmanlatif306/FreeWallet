<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyDepositMethodsTable extends Migration
{
    public function up()
    {   

        Schema::create('currency_deposit_methods', function (Blueprint $table) {

    		$table->id();
    		$table->unsignedBigInteger('currency_id')->nullable()->default(NULL);
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
    		$table->unsignedBigInteger('deposit_method_id');
            $table->foreign('deposit_method_id')->references('id')->on('deposit_methods')->onDelete('cascade')->onUpdate('cascade');
            // $table->unsignedInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
    		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('currency_deposit_methods');
    }
}