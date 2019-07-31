<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('day_events', function (Blueprint $table) {
            //
            $table->unsignedSmallInteger('month_year_id')->index()->nullable()->after('id');
            $table->foreign('month_year_id')->references('id')->on('month_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('day_events', function (Blueprint $table) {
            //
            $table->dropForeign(['month_year_id']);
            $table->dropColumn('month_year_id');
        });
    }
}
