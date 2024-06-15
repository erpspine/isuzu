<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToReviewConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('review_conversations', function (Blueprint $table) {
            $table->foreign(['user_id'], 'review_conversations_ibfk_1')->references(['id'])->on('users')->onDelete('no action');
            $table->foreign(['statusid'])->references(['id'])->on('attendance_statuses')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('review_conversations', function (Blueprint $table) {
            $table->dropForeign('review_conversations_ibfk_1');
            $table->dropForeign('review_conversations_statusid_foreign');
        });
    }
}
