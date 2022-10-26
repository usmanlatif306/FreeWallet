<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_methods', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
            $table->text('name')->nullable()->default(NULL);
            $table->text('accont_identifier_mechanism')->nullable()->default(NULL);
            $table->text('how_to_deposit')->nullable()->default(NULL);
            $table->text('how_to_withdraw')->nullable()->default(NULL);
            $table->integer('days_to_process_transfer')->default(1);
            $table->boolean('is_active',1)->default(1);
            $table->softdeletes();
            $table->timestamps();
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
