<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToQueryAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('query_answers', function (Blueprint $table) {
            $table->foreign(['query_id'])->references(['id'])->on('routingqueries')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('query_answers', function (Blueprint $table) {
            $table->dropForeign('query_answers_query_id_foreign');
        });
    }
}
