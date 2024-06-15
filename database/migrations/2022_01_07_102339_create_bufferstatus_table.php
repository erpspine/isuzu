<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBufferstatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bufferstatus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->integer('timline');
            $table->integer('paintshop');
            $table->integer('riveting');
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
        Schema::dropIfExists('bufferstatus');
    }
}
