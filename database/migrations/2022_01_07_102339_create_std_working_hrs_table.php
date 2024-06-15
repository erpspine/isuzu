<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdWorkingHrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_working_hrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shop_id')->index('std_working_hrs_shop_id_foreign');
            $table->unsignedBigInteger('model_id')->index('std_working_hrs_model_id_foreign');
            $table->float('std_hors', 10, 0);
            $table->unsignedBigInteger('user_id')->index('std_working_hrs_user_id_foreign');
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
        Schema::dropIfExists('std_working_hrs');
    }
}
