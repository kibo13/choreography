<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupWorkerTable extends Migration
{
    public function up()
    {
        Schema::create('group_worker', function (Blueprint $table) {
            $table->bigInteger('group_id')->unsigned();
            $table->bigInteger('worker_id')->unsigned();
            $table
                ->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');
            $table
                ->foreign('worker_id')
                ->references('id')
                ->on('workers')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_worker');
    }
}
