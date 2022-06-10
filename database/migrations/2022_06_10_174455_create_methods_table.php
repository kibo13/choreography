<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('methods', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('group_id')->unsigned();
            $table->bigInteger('lesson_id')->unsigned();
            $table->integer('month_id');
            $table->text('name');
            $table->double('hours');
            $table->text('note')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('methods');
    }
}
