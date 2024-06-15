<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOvertimepreviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overtimepreview', function (Blueprint $table) {
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
        Schema::table('overtimepreview', function (Blueprint $table) {
            $table->dropForeign('overtimepreview_shop_id_foreign');
            $table->dropForeign('overtimepreview_user_id_foreign');
        });
    }
}
