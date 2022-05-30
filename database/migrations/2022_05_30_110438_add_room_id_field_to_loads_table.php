<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoomIdFieldToLoadsTable extends Migration
{
    public function up()
    {
        Schema::table('loads', function (Blueprint $table) {
            $table->bigInteger('room_id')->unsigned()->nullable()->after('duration');
        });
    }

    public function down()
    {
        Schema::table('loads', function (Blueprint $table) {
            $table->dropColumn('room_id');
        });
    }
}
