<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueryDefectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('query_defects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('query_anwer_id')->index('query_defects_fk');
            $table->string('defect_name')->nullable();
            $table->enum('is_defect', ['Yes', 'No'])->nullable();
            $table->string('value_given')->nullable();
            $table->enum('is_addition', ['Yes', 'No'])->nullable();
            $table->enum('repaired', ['Yes', 'No'])->nullable()->default('No');
            $table->bigInteger('corrected_by')->nullable();
            $table->text('note')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('routingquery_id')->nullable();
            $table->bigInteger('shop_id')->nullable();
            $table->bigInteger('vehicle_id')->nullable();
            $table->string('defect_image')->nullable();
            $table->enum('done_by', ['Inspector', 'Admin'])->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->text('reason')->nullable();
            $table->enum('is_complete', ['Yes', 'No'])->nullable();
            $table->enum('stakeholder', ['MATERIAL HANDLING', 'PRODUCTION', 'LCD', 'PE', 'MH/S'])->nullable()->default('PRODUCTION');
            $table->string('defect_category')->nullable();
            $table->string('defect_corrected_by')->nullable();
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
        Schema::dropIfExists('query_defects');
    }
}
