<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lot_no');
            $table->string('vin_no');
            $table->string('engine_no');
            $table->string('job_no');
            $table->unsignedBigInteger('model_id')->index('vehicle_units_model_id_foreign');
            $table->string('color')->nullable();
            $table->date('schedule_date');
            $table->date('offline_date')->nullable();
            $table->date('start_date');
            $table->date('completion_date');
            $table->integer('status');
            $table->integer('route')->nullable();
            $table->tinyInteger('total_components')->nullable()->default(2);
            $table->tinyInteger('component_moved')->nullable();
            $table->date('date_completed')->nullable();
            $table->tinyInteger('cabin_cockpit_moved')->nullable()->default(0);
            $table->tinyInteger('chasis_moved')->nullable()->default(0);
            $table->string('sheduled_batch_no')->nullable();
            $table->unsignedBigInteger('sheduled_id');
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
        Schema::dropIfExists('vehicle_units');
    }
}
