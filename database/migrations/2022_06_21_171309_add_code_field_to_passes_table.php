<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeFieldToPassesTable extends Migration
{
    public function up()
    {
        Schema::table('passes', function (Blueprint $table) {
            $table->string('code')->nullable()->after('id');
            $table->integer('year')->nullable()->after('code');
            $table->integer('month')->nullable()->after('year');
        });
    }

    public function down()
    {
        Schema::table('passes', function (Blueprint $table) {
            $table->dropColumn(['code', 'year', 'month']);
        });
    }
}
