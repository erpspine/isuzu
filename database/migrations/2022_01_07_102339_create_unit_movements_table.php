<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_movements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('current_position', ['Inbuffer', 'InShop'])->nullable();
            $table->unsignedBigInteger('vehicle_id')->index('unit_movements_vehicle_id_foreign');
            $table->unsignedBigInteger('shop_id')->index('unit_movements_shop_id_foreign');
            $table->bigInteger('current_shop')->nullable();
            $table->unsignedBigInteger('route_id')->index('unit_movements_route_id_foreign');
            $table->unsignedBigInteger('route_number');
            $table->date('datetime_in');
            $table->date('datetime_out');
            $table->enum('done_by', ['inspector', 'stores', 'Admin'])->nullable();
            $table->integer('status')->nullable();
            $table->bigInteger('appuser_id')->nullable();
            $table->decimal('std_hrs', 16, 4)->nullable();
            $table->bigInteger('swap_id')->nullable();
            $table->bigInteger('swap_reference')->nullable();
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
        Schema::dropIfExists('unit_movements');
    }
}
