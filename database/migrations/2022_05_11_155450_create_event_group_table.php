<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventGroupTable extends Migration
{
    public function up()
    {
        Schema::create('event_group', function (Blueprint $table) {
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('group_id')->unsigned();
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');
            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_group');
    }
}
