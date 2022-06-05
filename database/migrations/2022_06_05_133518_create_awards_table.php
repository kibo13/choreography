<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardsTable extends Migration
{
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('num')->unique();
            $table->date('date_reg');
            $table->date('date_doc');
            $table->string('name_doc');
            $table->bigInteger('group_id')->unsigned();
            $table->bigInteger('orgkomitet_id')->unsigned();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('awards');
    }
}
