<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->dateTime('from')->nullable();
            $table->dateTime('till')->nullable();
            $table->bigInteger('worker_id')->unsigned()->nullable();
            $table->bigInteger('room_id')->unsigned()->nullable();
            $table->integer('is_replace')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('timetables');
    }
}
