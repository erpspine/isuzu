<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAttendanceStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance_statuses', function (Blueprint $table) {
            $table->foreign(['shop_id'])->references(['id'])->on('shops')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_statuses', function (Blueprint $table) {
            $table->dropForeign('attendance_statuses_shop_id_foreign');
            $table->dropForeign('attendance_statuses_user_id_foreign');
        });
    }
}
