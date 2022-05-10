<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSizeFieldToDiscountsTable extends Migration
{
    public function up()
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->integer('size')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->tinyInteger('size')->nullable(false)->change();
        });
    }
}
