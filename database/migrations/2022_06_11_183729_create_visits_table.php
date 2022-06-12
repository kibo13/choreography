<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->unsigned();
            $table->bigInteger('timetable_id')->unsigned();

            $table->foreign('member_id')
                ->references('id')
                ->on('members')
                ->onDelete('cascade');

            $table->foreign('timetable_id')
                ->references('id')
                ->on('timetables')
                ->onDelete('cascade');

            $table->integer('status');
            $table->string('reason')->nullable();
            $table->text('file')->nullable();
            $table->string('note')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
