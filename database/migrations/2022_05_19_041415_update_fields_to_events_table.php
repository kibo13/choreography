<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldsToEventsTable extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('type')->nullable(true)->change();
            $table->date('from')->nullable(false)->change();
            $table->date('till')->nullable(true)->change();
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('type')->nullable(false)->change();
            $table->dateTime('from')->nullable(false)->change();
            $table->dateTime('till')->nullable(false)->change();
        });
    }
}
