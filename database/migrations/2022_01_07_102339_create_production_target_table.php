<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_target', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('level', ['offline', 'fcw'])->nullable()->default('offline');
            $table->date('date');
            $table->unsignedBigInteger('route_id')->index('production_target_ibfk_1');
            $table->date('shop1')->nullable();
            $table->date('shop2')->nullable();
            $table->date('shop3')->nullable();
            $table->date('shop5')->nullable();
            $table->date('shop6')->nullable();
            $table->date('shop8')->nullable();
            $table->date('shop10')->nullable();
            $table->date('shop11')->nullable();
            $table->date('shop12')->nullable();
            $table->date('shop13')->nullable();
            $table->date('shop16')->nullable();
            $table->date('cv');
            $table->date('lcv');
            $table->integer('noofunits');
            $table->unsignedBigInteger('user_id')->index('user_id');
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
        Schema::dropIfExists('production_target');
    }
}
