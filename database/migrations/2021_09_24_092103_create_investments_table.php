<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('investmentplan_id');
            $table->foreign('investmentplan_id')->references('id')->on('investmentplans')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('capital', 16,8)->default(0.00);
            $table->decimal('earnings', 16,8)->default(0.00);
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->boolean('status',1)->default(1);
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
        Schema::dropIfExists('investments');
    }
}
