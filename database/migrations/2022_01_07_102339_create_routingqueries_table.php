<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutingqueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routingqueries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->index('routing_queries_category_id_foreign');
            $table->enum('can_sign', ['Yes', 'No'])->nullable()->default('No');
            $table->text('query_name')->nullable();
            $table->enum('use_defferent_routing', ['Yes', 'No', '', ''])->default('No');
            $table->integer('total_options');
            $table->string('quiz_type');
            $table->enum('additional_field', ['Yes', 'No'])->nullable()->default('No');
            $table->tinyInteger('total_correct_answer');
            $table->text('answers');
            $table->text('correct_answers');
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
        Schema::dropIfExists('routingqueries');
    }
}
