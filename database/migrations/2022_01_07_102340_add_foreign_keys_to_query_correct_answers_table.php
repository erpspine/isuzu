<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToQueryCorrectAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('query_correct_answers', function (Blueprint $table) {
            $table->foreign(['answer_id'])->references(['id'])->on('query_answers')->onDelete('no action');
            $table->foreign(['query_id'])->references(['id'])->on('routingqueries')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('query_correct_answers', function (Blueprint $table) {
            $table->dropForeign('query_correct_answers_answer_id_foreign');
            $table->dropForeign('query_correct_answers_query_id_foreign');
        });
    }
}
