<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('withdrawal_methods', function (Blueprint $table) {

			$table->id();
			$table->string('name',191);
			$table->longText('comment')->nullable()->default(NULL);
			$table->decimal('percentage_fee', 5 , 2)->default(NULL);
			$table->decimal('fixed_fee', 16 , 8)->default(0);
			$table->text('json_data')->nullable()->default(NULL);
			$table->string('thumb',191)->nullable()->default(NULL);
			$table->string('method_identifier_field__name',191)->nullable()->default(NULL);
			$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('withdrawal_methods');
    }
}