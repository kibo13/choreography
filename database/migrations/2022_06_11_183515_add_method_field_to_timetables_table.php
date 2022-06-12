<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMethodFieldToTimetablesTable extends Migration
{
    public function up()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->bigInteger('method_id')->unsigned()->nullable();
            $table->text('note')->nullable();
        });
    }

    public function down()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->dropColumn(['method_id', 'note']);
        });
    }
}
