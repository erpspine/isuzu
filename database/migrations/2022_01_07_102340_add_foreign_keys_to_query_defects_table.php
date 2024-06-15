<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToQueryDefectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('query_defects', function (Blueprint $table) {
            $table->foreign(['query_anwer_id'], 'query_defects_fk')->references(['id'])->on('query_answers')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('query_defects', function (Blueprint $table) {
            $table->dropForeign('query_defects_fk');
        });
    }
}
