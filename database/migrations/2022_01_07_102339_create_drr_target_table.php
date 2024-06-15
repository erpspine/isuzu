<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrrTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drr_target', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('target_name', 299)->nullable();
            $table->enum('active', ['Active', 'Inactive'])->nullable();
            $table->date('fromdate')->nullable();
            $table->date('todate')->nullable();
            $table->decimal('plant_target', 16)->nullable();
            $table->enum('target_type', ['Drl', 'Drr'])->nullable();
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
        Schema::dropIfExists('drr_target');
    }
}
