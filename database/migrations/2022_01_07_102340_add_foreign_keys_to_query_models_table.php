<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToQueryModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('query_models', function (Blueprint $table) {
            $table->foreign(['querycategory_id'], 'quiz_models_quiz_category_id_foreign')->references(['id'])->on('querycategories')->onDelete('CASCADE');
            $table->foreign(['unit_model_id'], 'quiz_models_unit_model_id_foreign')->references(['id'])->on('unit_models')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('query_models', function (Blueprint $table) {
            $table->dropForeign('quiz_models_quiz_category_id_foreign');
            $table->dropForeign('quiz_models_unit_model_id_foreign');
        });
    }
}
