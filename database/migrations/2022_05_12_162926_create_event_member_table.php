<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventMemberTable extends Migration
{
    public function up()
    {
        Schema::create('event_member', function (Blueprint $table) {
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('member_id')->unsigned();
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');
            $table->foreign('member_id')
                ->references('id')
                ->on('members')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_member');
    }
}
