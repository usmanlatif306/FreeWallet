<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {

    		$table->id();
    		$table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
    		$table->string('document_type')->nullable()->default(NULL);
    		$table->string('document')->nullable()->default(NULL);
    		$table->string('phone_number')->nullable()->default(NULL);
    		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}