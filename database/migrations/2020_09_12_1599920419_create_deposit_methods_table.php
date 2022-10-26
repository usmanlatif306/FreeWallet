<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('deposit_methods', function (Blueprint $table) {

    		$table->id();
    		$table->string('name',191);
    		$table->longText('how_to')->nullable()->default(NULL);
    		$table->text('json_data')->nullable()->default(NULL);
    		$table->string('thumb',191)->nullable()->default(NULL);
    		$table->string('method_identifier_field__name',191)->nullable()->default(NULL);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deposit_methods');
    }
}