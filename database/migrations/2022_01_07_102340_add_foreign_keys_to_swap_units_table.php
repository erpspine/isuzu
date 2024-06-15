<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSwapUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('swap_units', function (Blueprint $table) {
            $table->foreign(['swap_unit'], 'swap_unit_id_foreign')->references(['id'])->on('vehicle_units')->onDelete('CASCADE');
            $table->foreign(['from_shop_id'])->references(['id'])->on('shops')->onDelete('CASCADE');
            $table->foreign(['swap_with_unit'], 'swap_with_unitid_foreign')->references(['id'])->on('vehicle_units')->onDelete('no action');
            $table->foreign(['done_by'])->references(['id'])->on('users')->onDelete('CASCADE');
            $table->foreign(['to_shop_id'])->references(['id'])->on('shops')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('swap_units', function (Blueprint $table) {
            $table->dropForeign('swap_unit_id_foreign');
            $table->dropForeign('swap_units_from_shop_id_foreign');
            $table->dropForeign('swap_with_unitid_foreign');
            $table->dropForeign('swap_units_done_by_foreign');
            $table->dropForeign('swap_units_to_shop_id_foreign');
        });
    }
}
