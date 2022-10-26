<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {

			$table->id();
			$table->integer('attempts')->default(0);
			$table->string('merchant_key',191);
			$table->string('ref',191);
			$table->boolean('is_expired');
			$table->text('data');
			$table->string('currency_code')->nullable()->default(NULL);
			$table->unsignedBigInteger('currency_id');
	        $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
	        $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
}