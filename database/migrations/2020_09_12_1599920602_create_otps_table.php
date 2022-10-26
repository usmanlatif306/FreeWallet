<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {

    		$table->id();
    		$table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
    		$table->string('otp',191)->nullable()->default(NULL);
    		$table->timestamps();
            $table->softDeletes('deleted_at', 0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('otps');
    }
}