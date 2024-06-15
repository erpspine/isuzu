<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorisedhrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorisedhrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('datefrom');
            $table->dateTime('dateto');
            $table->decimal('weekdayhrs', 4);
            $table->decimal('wknd_hdayhrs', 4);
            $table->unsignedBigInteger('user_id')->index('authorisedhrs_user_id_foreign');
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
        Schema::dropIfExists('authorisedhrs');
    }
}
