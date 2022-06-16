<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveFieldToPassesTable extends Migration
{
    public function up()
    {
        Schema::table('passes', function (Blueprint $table) {
            $table->integer('is_active')->default(1);
        });
    }

    public function down()
    {
        Schema::table('passes', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}
