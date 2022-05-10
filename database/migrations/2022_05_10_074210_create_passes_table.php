<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassesTable extends Migration
{
    public function up()
    {
        Schema::create('passes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->unsigned();
            $table->bigInteger('group_id')->unsigned();
            $table->bigInteger('worker_id')->unsigned();
            $table->date('from');
            $table->date('till');
            $table->double('cost');
            $table->tinyInteger('lessons');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('passes');
    }
}
