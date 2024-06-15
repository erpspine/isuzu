<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwapUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swap_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_shop_id')->index('swap_units_from_shop_id_foreign');
            $table->unsignedBigInteger('to_shop_id')->index('swap_units_to_shop_id_foreign');
            $table->unsignedBigInteger('done_by')->index('swap_units_done_by_foreign');
            $table->unsignedBigInteger('swap_unit')->index('swap_unit_id_foreign');
            $table->unsignedBigInteger('swap_with_unit')->index('swap_with_unitid_foreign');
            $table->string('swap_reference')->nullable();
            $table->text('reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swap_units');
    }
}
