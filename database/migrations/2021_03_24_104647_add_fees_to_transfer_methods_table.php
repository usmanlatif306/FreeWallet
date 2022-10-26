<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeesToTransferMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfer_methods', function (Blueprint $table) {
            $table->decimal('deposit_percentage_fee', 16, 8)->nullable()->default(0);
            $table->decimal('deposit_fixed_fee', 16, 8)->nullable()->default(0);
            $table->decimal('withdraw_percentage_fee', 16, 8)->nullable()->default(0);
            $table->decimal('withdraw_fixed_fee', 16, 8)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('transfer_methods');
    }
}
