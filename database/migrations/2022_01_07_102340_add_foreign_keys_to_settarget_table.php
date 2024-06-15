<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSettargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settarget', function (Blueprint $table) {
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
        Schema::table('settarget', function (Blueprint $table) {
            $table->dropForeign('settarget_shop_id_foreign');
            $table->dropForeign('settarget_user_id_foreign');
        });
    }
}
