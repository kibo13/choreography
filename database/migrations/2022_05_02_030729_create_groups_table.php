<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('title_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->tinyInteger('basic_seats');
            $table->tinyInteger('extra_seats')->nullable();
            $table->tinyInteger('age_from');
            $table->tinyInteger('age_till');
            $table->double('price')->nullable();
            $table->tinyInteger('lessons')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
