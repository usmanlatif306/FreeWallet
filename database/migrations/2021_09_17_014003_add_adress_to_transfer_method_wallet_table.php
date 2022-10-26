<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdressToTransferMethodWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfer_method_wallet', function (Blueprint $table) {
            $table->text('adress')->nullable()->defaul(NULL); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfer_method_wallet', function (Blueprint $table) {
            $table->dropColumn('adress');
        });
    }
}
