<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_name');
            $table->string('model_number');
            $table->unsignedBigInteger('vehicle_type_id')->index('unit_models_vehicle_type_id_foreign');
            $table->unsignedBigInteger('user_id')->index('unit_models_user_id_foreign');
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
        Schema::dropIfExists('unit_models');
    }
}
