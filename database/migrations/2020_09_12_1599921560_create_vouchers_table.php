<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {

			$table->id();
			$table->unsignedBigInteger('user_id');
		    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->string('voucher_code',191);
			$table->text('json_data')->nullable()->default(NULL);
			$table->unsignedBigInteger('currency_id');
	        $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
			$table->string('currency_symbol')->nullable()->default(NULL);
			$table->integer('user_loader')->nullable()->default(NULL);
			$table->boolean('is_loaded',4)->default(0);
			$table->decimal('voucher_fee' , 16,8)->nullable()->default(NULL);
			$table->decimal('voucher_value', 19 , 8)->nullable()->default(NULL);
			$table->decimal('voucher_amount', 19 , 8)->default(NULL);
			$table->unsignedBigInteger('wallet_id');
	        $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade')->onUpdate('cascade');
			$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}