<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcaScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gca_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->enum('lcv_cv', ['lcv', 'cv', '', '']);
            $table->integer('defectcar1');
            $table->integer('defectcar2');
            $table->decimal('mtdwdpv', 4);
            $table->integer('units_sampled');
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
        Schema::dropIfExists('gca_scores');
    }
}
