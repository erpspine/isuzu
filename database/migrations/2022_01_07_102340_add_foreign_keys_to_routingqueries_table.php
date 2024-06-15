<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToRoutingqueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routingqueries', function (Blueprint $table) {
            $table->foreign(['category_id'], 'routing_queries_category_id_foreign')->references(['id'])->on('querycategories')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routingqueries', function (Blueprint $table) {
            $table->dropForeign('routing_queries_category_id_foreign');
        });
    }
}
