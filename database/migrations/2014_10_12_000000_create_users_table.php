<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->string('email', 191)->unique();
            $table->string('name',191);
            $table->string('first_name',191)->nullable()->default(NULL);
            $table->string('last_name',191)->nullable()->default(NULL);
            $table->string('avatar',191)->default('users/default.png');
            $table->string('password',191)->nullable()->default(NULL);
            $table->boolean('verified',1)->default(0);
            $table->boolean('merchant',1)->default(0);
            $table->boolean('social',1)->default(0);
            $table->decimal('balance', 13 ,  2)->default(0.00);
            $table->text('json_data')->nullable()->default(NULL);
            $table->boolean('account_status',1)->default(1);
            $table->integer('currency_id')->nullable()->default(NULL);
            $table->boolean('is_ticket_admin',4)->default(0);
            $table->text('verification_token')->nullable()->default(NULL);
            $table->string('whatsapp',191)->nullable()->default(NULL);
            $table->string('phonenumber',191)->nullable()->default(NULL);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
