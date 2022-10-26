<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketcategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('ticketcategories', function (Blueprint $table) {

    		$table->id();
    		$table->string('name')->nullable()->default(NULL);
    		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('ticketcategories');
    }
}