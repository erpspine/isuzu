<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimepreviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimepreview', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date');
            $table->unsignedBigInteger('shop_id')->index('overtimepreview_shop_id_foreign');
            $table->unsignedBigInteger('user_id')->index('overtimepreview_user_id_foreign');
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
        Schema::dropIfExists('overtimepreview');
    }
}
