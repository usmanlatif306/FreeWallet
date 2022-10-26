<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestmentplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investmentplans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
             $table->unsignedBigInteger('transfer_method_id');
            $table->foreign('transfer_method_id')->references('id')->on('transfer_methods')->onDelete('cascade')->onUpdate('cascade');
            $table->text('name')->nullable()->default(NULL);
            $table->integer('min_profit_percentage')->nullable()->default(NULL);
            $table->integer('max_profit_percentage')->nullable()->default(NULL);
            $table->decimal('min_investment', 16,8)->default(0.00);
            $table->decimal('max_investment', 16,8)->default(0.00);
            $table->text('withdraw_interval_days')->nullable()->default(NULL);
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
        Schema::dropIfExists('investmentplans');
    }
}
