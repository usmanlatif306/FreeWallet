<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalsTable extends Migration
{
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {

			$table->id();
			$table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('transaction_state_id');
			$table->unsignedBigInteger('withdrawal_method_id');
            $table->foreign('withdrawal_method_id')->references('id')->on('withdrawal_methods')->onDelete('cascade')->onUpdate('cascade');
			$table->decimal('gross',19,8)->default(NULL);
			$table->decimal('fee',16,8)->default(NULL);
			$table->decimal('net',19,8)->default(NULL);
			$table->text('platform_id');
			$table->text('json_data')->nullable()->default(NULL);
			$table->string('currency_symbol')->nullable()->default(NULL);
			$table->unsignedBigInteger('wallet_id');
	        $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade')->onUpdate('cascade');
			$table->string('send_to_platform_name')->nullable()->default(NULL);
		    $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
}