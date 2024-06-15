<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOvertimeremarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overtimeremarks', function (Blueprint $table) {
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
        Schema::table('overtimeremarks', function (Blueprint $table) {
            $table->dropForeign('overtimeremarks_shop_id_foreign');
            $table->dropForeign('overtimeremarks_user_id_foreign');
        });
    }
}
