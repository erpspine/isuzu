<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shop_name');
            $table->integer('shop_no');
            $table->string('report_name');
            $table->integer('offline')->default(0);
            $table->integer('check_shop')->nullable();
            $table->integer('overtime');
            $table->integer('check_point');
            $table->integer('group_shop');
            $table->tinyInteger('group_order')->nullable()->default(0);
            $table->integer('buffer');
            $table->enum('lcvcv_share', ['share', 'cv', 'lcv'])->nullable();
            $table->integer('off_days');
            $table->integer('no_of_sections');
            $table->integer('drl_shops');
            $table->string('color_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
