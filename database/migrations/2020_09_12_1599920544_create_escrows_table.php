<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscrowsTable extends Migration
{
    public function up()
    {
        Schema::create('escrows', function (Blueprint $table) {

			$table->id();
			$table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->unsignedBigInteger('to');
            $table->foreign('to')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->decimal('gross',19,8)->nullable()->default(NULL);
			$table->text('description')->nullable()->default(NULL);
			$table->text('json_data')->nullable()->default(NULL);
			$table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
			$table->string('currency_symbol',10)->nullable()->default(NULL);
			$table->string('escrow_transaction_status')->nullable()->default(NULL);
			$table->boolean('agreement',4)->default(0);
			$table->timestamps();
			$table->softDeletes('deleted_at', 0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('escrows');
    }
}