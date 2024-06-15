<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeecategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeecategory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_code', 20)->unique('UQ_category');
            $table->string('emp_category');
            $table->unsignedBigInteger('user_id')->index('employeecategory_user_id_foreign');
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
        Schema::dropIfExists('employeecategory');
    }
}
