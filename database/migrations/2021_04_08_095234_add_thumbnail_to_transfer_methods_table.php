<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbnailToTransferMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('transfer_methods', function (Blueprint $table) {
            $table->longText('thumbnail')->nullable()->defaul(NULL);
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfer_methods', function (Blueprint $table) {
             $table->longText('thumbnail')->nullable()->defaul(NULL);
        });
    }
}
