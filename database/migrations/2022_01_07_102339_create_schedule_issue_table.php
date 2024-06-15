<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_issue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('level', ['offline', 'fcw'])->nullable();
            $table->date('month');
            $table->integer('issue_no')->default(0);
            $table->string('comment');
            $table->unsignedBigInteger('user_id')->index('user_id');
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
        Schema::dropIfExists('schedule_issue');
    }
}
