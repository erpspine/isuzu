<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndivTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indiv_target', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('datefrom');
            $table->dateTime('dateto');
            $table->decimal('efficiency', 4);
            $table->decimal('absentieesm', 4);
            $table->decimal('tlavailability', 4);
            $table->enum('status', ['Active', 'Inactive', '', ''])->default('Inactive');
            $table->unsignedBigInteger('user_id')->index('indiv_target_user_id_foreign');
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
        Schema::dropIfExists('indiv_target');
    }
}
