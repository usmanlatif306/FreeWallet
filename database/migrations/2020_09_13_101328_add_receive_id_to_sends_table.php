<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceiveIdToSendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sends', function (Blueprint $table) {
            $table->unsignedBigInteger('receive_id')->nullable()->defaul(NULL);
            $table->foreign('receive_id')->references('id')->on('receives')->onDelete('cascade')->onUpdate('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sends', function (Blueprint $table) {
            $table->dropColumn('receive_id');
        });
    }
}
