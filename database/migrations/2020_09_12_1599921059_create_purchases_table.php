<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {

			$table->id();
			$table->unsignedBigInteger('user_id');
		    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->unsignedBigInteger('merchant_id');
		    $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('transaction_state_id');
			$table->decimal('gross', 19,8)->default(NULL);
			$table->decimal('fee', 16,8)->default(NULL);
			$table->decimal('net', 19,8)->default(NULL);
			$table->text('json_data')->nullable()->default(NULL);
			$table->unsignedBigInteger('currency_id');
	        $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
			$table->string('currency_symbol')->nullable()->default(NULL);
			$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}