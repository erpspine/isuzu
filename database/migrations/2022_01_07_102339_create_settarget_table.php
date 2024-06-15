<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settarget', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shop_id')->index('settarget_shop_id_foreign');
            $table->dateTime('datefrom');
            $table->dateTime('dateto');
            $table->decimal('efficiency', 4);
            $table->decimal('absentieesm', 4);
            $table->decimal('tlavailability', 4);
            $table->unsignedBigInteger('user_id')->index('settarget_user_id_foreign');
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
        Schema::dropIfExists('settarget');
    }
}
