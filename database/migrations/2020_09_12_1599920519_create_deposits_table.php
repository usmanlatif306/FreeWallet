<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {

			$table->id();
			$table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('transaction_state_id');
			$table->unsignedBigInteger('deposit_method_id');
            $table->foreign('deposit_method_id')->references('id')->on('deposit_methods')->onDelete('cascade')->onUpdate('cascade');
			$table->decimal('gross',19,8)->default(NULL);
			$table->decimal('fee',16,8)->default(NULL);
			$table->decimal('net',19,8)->default(NULL);
			$table->text('transaction_receipt')->nullable();
			$table->text('json_data')->nullable();
			$table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
			$table->string('currency_symbol')->nullable();
			$table->unsignedBigInteger('wallet_id');
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade')->onUpdate('cascade');
			$table->text('message')->nullable();
			$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('deposits');
    }
}