<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransferMethodFieldsToWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('wallets', function (Blueprint $table) {
           $table->text('transfer_method_id')->nullable()->default(NULL);
           $table->text('accont_identifier_mechanism_value')->nullable()->default(NULL);
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('wallets', function (Blueprint $table) {
            $table->text('transfer_method_id');
            $table->text('accont_identifier_mechanism_value');
        });
    }
}
