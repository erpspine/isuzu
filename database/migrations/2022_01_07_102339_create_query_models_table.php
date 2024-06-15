<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueryModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('query_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('querycategory_id')->index('quiz_models_quiz_category_id_foreign');
            $table->unsignedBigInteger('unit_model_id')->index('quiz_models_unit_model_id_foreign');
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
        Schema::dropIfExists('query_models');
    }
}
