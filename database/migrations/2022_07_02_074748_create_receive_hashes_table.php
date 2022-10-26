<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiveHashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_hashes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attempts')->default(0);
            $table->string('merchant_key', 191);
            $table->string('ref', 191);
            $table->boolean('is_expired');
            $table->text('data');
            $table->string('currency_code')->nullable()->default(NULL);
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receive_hashes');
    }
}
