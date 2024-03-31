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
            $table->string('name');
            $table->string('slug');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_image')->default('default.jpg');
            $table->date('birthdate');
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('status')->default('0');
            $table->integer('e_notif')->default('1');
            $table->string('invited_by')->nullable();
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
