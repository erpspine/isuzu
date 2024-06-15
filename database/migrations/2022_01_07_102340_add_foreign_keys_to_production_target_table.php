<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProductionTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_target', function (Blueprint $table) {
            $table->foreign(['route_id'], 'production_target_ibfk_1')->references(['id'])->on('unit_routes')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'production_target_ibfk_2')->references(['id'])->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production_target', function (Blueprint $table) {
            $table->dropForeign('production_target_ibfk_1');
            $table->dropForeign('production_target_ibfk_2');
        });
    }
}
