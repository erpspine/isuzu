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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->nullable();
            $table->string('phone_no')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('passw', 20);
            $table->string('password');
            $table->rememberToken();
            $table->enum('status', ['Active', 'Inactive', '', '']);
            $table->timestamps();
            $table->integer('superAdmin');
            $table->string('section', 10)->nullable()->default('0');
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
