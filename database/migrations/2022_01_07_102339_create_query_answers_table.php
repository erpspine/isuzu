<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueryAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('query_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_id')->nullable();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('query_id')->index('query_answers_query_id_foreign');
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('shop_id')->nullable();
            $table->string('answer')->nullable();
            $table->enum('has_error', ['Yes', 'No'])->nullable();
            $table->tinyInteger('additional_query')->nullable()->default(0);
            $table->bigInteger('done_by')->nullable();
            $table->string('icon')->nullable();
            $table->string('signature')->nullable();
            $table->bigInteger('swap_reference')->nullable();
            $table->bigInteger('swap_id')->nullable();
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
        Schema::dropIfExists('query_answers');
    }
}
