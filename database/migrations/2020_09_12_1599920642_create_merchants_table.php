<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {

			$table->id();
			$table->unsignedBigInteger('user_id');
	        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->text('merchant_key');
			$table->string('site_url',191);
			$table->string('success_link',191);
			$table->string('fail_link',191);
			$table->string('logo',191)->nullable()->default(NULL);
			$table->string('name',191);
			$table->string('description',191)->nullable()->default(NULL);
			$table->text('json_data')->nullable()->default(NULL);
			$table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
			$table->string('thumb',191)->nullable()->default(NULL);
			$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('merchants');
    }
}