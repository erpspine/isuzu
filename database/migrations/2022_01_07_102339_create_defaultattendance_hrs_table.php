<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultattendanceHrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defaultattendance_hrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('direct', 16);
            $table->decimal('indirect', 16);
            $table->decimal('overtime', 4);
            $table->decimal('hrslimit', 16);
            $table->unsignedBigInteger('user_id')->index('defaultattendance_hrs_user_id_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defaultattendance_hrs');
    }
}
