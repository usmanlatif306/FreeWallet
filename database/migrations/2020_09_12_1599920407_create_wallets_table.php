<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {

		    $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		    $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_crypto',1)->default(0);
            $table->decimal('amount', 8,2)->default(0.00);
            $table->decimal('crypto', 16,8)->default(0.00);
            $table->decimal('fiat', 13,2)->default(0.00);
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}