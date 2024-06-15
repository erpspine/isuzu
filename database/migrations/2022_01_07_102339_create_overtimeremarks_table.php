<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimeremarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimeremarks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date');
            $table->unsignedBigInteger('shop_id')->index('overtimeremarks_shop_id_foreign');
            $table->string('remarks');
            $table->unsignedBigInteger('user_id')->index('overtimeremarks_user_id_foreign');
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
        Schema::dropIfExists('overtimeremarks');
    }
}
