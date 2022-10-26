<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionableTable extends Migration
{
    public function up()
    {
        Schema::create('transactionable', function (Blueprint $table) {

			$table->id();
			$table->unsignedBigInteger('user_id');
		    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('request_id')->nullable()->default(NULL);
			$table->integer('transactionable_id');
			$table->string('transactionable_type',191);
			$table->integer('entity_id');
			$table->string('entity_name',191);
			$table->integer('transaction_state_id');
			$table->string('currency',191)->default('USD');
			$table->string('activity_title',191);
			$table->string('money_flow',191);
			$table->decimal('gross', 19,8)->default(NULL);
			$table->decimal('fee', 16 , 8)->default(NULL);
			$table->decimal('net', 19 , 8)->default(NULL);
			$table->decimal('balance', 19,8)->nullable()->default(NULL);
			$table->text('json_data')->nullable()->default(NULL);
			$table->string('currency_symbol')->nullable()->default(NULL);
			$table->string('thumb',191)->default('users/default.png');
			$table->unsignedBigInteger('currency_id');
	        $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
	        $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('transactionable');
    }
}