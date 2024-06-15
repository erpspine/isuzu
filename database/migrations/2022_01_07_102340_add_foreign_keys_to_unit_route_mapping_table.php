<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUnitRouteMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_route_mapping', function (Blueprint $table) {
            $table->foreign(['shop_id'], 'unit_routings_shop_id_foreign')->references(['id'])->on('shops')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_route_mapping', function (Blueprint $table) {
            $table->dropForeign('unit_routings_shop_id_foreign');
        });
    }
}
