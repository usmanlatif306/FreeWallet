<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    public function up()
    {   
        Schema::enableForeignKeyConstraints();
        Schema::create('currencies', function (Blueprint $table) {

    		$table->id()->unsigned();
    		$table->string('name')->nullable();
    		$table->string('symbol')->nullable();
    		$table->string('code')->nullable();
    		$table->boolean('is_cripto',1)->default(0);
            $table->boolean('is_crypto',1)->default(0);
    		$table->string('thumb',191)->nullable();

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}