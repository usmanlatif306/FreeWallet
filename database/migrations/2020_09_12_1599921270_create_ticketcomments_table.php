<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketcommentsTable extends Migration
{
    public function up()
    {
        Schema::create('ticketcomments', function (Blueprint $table) {

    		$table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
    		$table->unsignedBigInteger('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade')->onUpdate('cascade');
    		$table->text('comment')->nullable()->default(NULL);
    		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('ticketcomments');
    }
}