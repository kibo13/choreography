<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->bigInteger('member_id')->unsigned()->after('num');
            $table->bigInteger('group_id')->unsigned()->after('member_id');
            $table->bigInteger('worker_id')->unsigned()->nullable()->after('group_id');
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->dropColumn(['member_id', 'group_id', 'worker_id']);
        });
    }
}
