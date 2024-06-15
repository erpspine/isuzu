<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuerycategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('querycategories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('query_code');
            $table->unsignedBigInteger('shop_id');
            $table->string('category_name');
            $table->enum('status', ['Active', 'Inactive'])->nullable();
            $table->text('model_id')->nullable();
            $table->integer('total_options')->nullable();
            $table->string('quiz_type')->nullable();
            $table->tinyInteger('total_correct_answers')->nullable();
            $table->text('answers')->nullable();
            $table->text('correct_answers')->nullable();
            $table->string('icon')->nullable()->default('default.jpg');
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('querycategories');
    }
}
