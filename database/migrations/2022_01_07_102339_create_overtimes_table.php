<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('emp_id')->index('overtimes_emp_id_foreign');
            $table->decimal('othours', 4);
            $table->decimal('loaned_hrs', 4);
            $table->integer('shop_loaned_to');
            $table->unsignedBigInteger('shop_id')->index('overtimes_shop_id_foreign');
            $table->unsignedBigInteger('user_id')->index('overtimes_user_id_foreign');
            $table->integer('loan_confirm');
            $table->dateTime('date');
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
        Schema::dropIfExists('overtimes');
    }
}
