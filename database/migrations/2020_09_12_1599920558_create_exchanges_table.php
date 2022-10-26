<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangesTable extends Migration
{
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {

		$table->id();
		$table->unsignedBigInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		$table->unsignedBigInteger('first_currency_id');
        $table->foreign('first_currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
        $table->unsignedBigInteger('second_currency_id');
        $table->foreign('second_currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
		$table->decimal('gross',19,8)->nullable()->default(NULL);
		$table->decimal('fee',16,8)->nullable()->default(NULL);
		$table->decimal('net',19,8)->nullable()->default(NULL);
		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('exchanges');
    }
}