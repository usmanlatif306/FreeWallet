<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {

			$table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->unsignedBigInteger('ticketcategory_id');
            $table->foreign('ticketcategory_id')->references('id')->on('ticketcategories')->onDelete('cascade')->onUpdate('cascade');
			$table->unsignedBigInteger('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade')->onUpdate('cascade');
			$table->string('title')->nullable()->default(NULL);
			$table->string('priority')->nullable()->default(NULL);
			$table->text('message')->nullable()->default(NULL);
			$table->string('status')->nullable()->default(NULL);
			$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}