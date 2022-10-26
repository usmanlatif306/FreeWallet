<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
			$table->id();
			$table->char('code',2);
			$table->string('name');
			$table->string('nicename');
			$table->char('iso3',3)->nullable();
			//$table->smallInteger('numcode',6)->nullable()->default('NULL');
			$table->smallInteger('numcode')->nullable();
			$table->string('prefix',7);
			$table->timestamps();
			$table->softDeletes('deleted_at', 0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
}