<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrrTargetShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drr_target_shop', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('target_id')->nullable();
            $table->bigInteger('shop_id')->nullable();
            $table->decimal('target_value', 16)->nullable();
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
        Schema::dropIfExists('drr_target_shop');
    }
}
