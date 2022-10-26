<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransferMethodIdToWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->unsignedBigInteger('transfer_method_id')->nullable()->defaul(NULL);
            // $table->foreign('transfer_method_id')->references('id')->on('transfer_methods')->onDelete('cascade')->onUpdate('cascade');
            $table->string('unique_transaction_id',191)->nullable()->default(NULL);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn('transfer_method_id');
            $table->dropColumn('unique_transaction_id');
        });
    }
}
