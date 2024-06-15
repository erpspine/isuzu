<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('unique_no');
            $table->string('staff_no');
            $table->string('staff_name');
            $table->string('Department_Description');
            $table->string('Category');
            $table->integer('empcategory_id');
            $table->string('Role');
            $table->unsignedBigInteger('shop_id')->index('employees_shop_id_foreign');
            $table->enum('gender', ['Male', 'Female', '', ''])->default('Male');
            $table->enum('status', ['Active', 'Inactive', '', ''])->default('Active');
            $table->enum('team_leader', ['yes', 'no', '', ''])->default('no');
            $table->unsignedBigInteger('user_id')->index('employees_user_id_foreign');
            $table->softDeletes();
            $table->timestamps();
            $table->enum('outsource', ['no', 'yes'])->nullable()->default('no');
            $table->date('outsource_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
