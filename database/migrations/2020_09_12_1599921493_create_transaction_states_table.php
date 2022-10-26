<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionStatesTable extends Migration
{
    public function up()
    {
        Schema::create('transaction_states', function (Blueprint $table) {

    		$table->id();
    		$table->string('name');
    		$table->text('json_data')->nullable()->default(NULL);
    		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction_states');
    }
}