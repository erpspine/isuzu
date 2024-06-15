<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedBigInteger('shop_id')->index('attendances_shop_id_foreign');
            $table->unsignedBigInteger('staff_id')->index('attendances_staff_id_foreign');
            $table->decimal('efficiencyhrs', 4);
            $table->float('direct_hrs', 10, 0)->default(0);
            $table->float('indirect_hrs', 10, 0)->default(0);
            $table->float('loaned_hrs', 10, 0)->nullable()->default(0);
            $table->integer('shop_loaned_to');
            $table->decimal('auth_othrs', 4);
            $table->decimal('othours', 4)->default(0);
            $table->decimal('indirect_othours', 4)->default(0);
            $table->decimal('otloaned_hrs', 4)->default(0);
            $table->integer('otshop_loaned_to');
            $table->char('workdescription')->nullable();
            $table->integer('loan_confirm');
            $table->unsignedBigInteger('user_id')->index('attendances_user_id_foreign');
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
        Schema::dropIfExists('attendances');
    }
}
