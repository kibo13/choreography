<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFileFieldToApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->integer('topic')->change();
            $table->json('files')->nullable();
            $table->dropColumn('file');
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('topic')->change();
            $table->text('file')->nullable();
            $table->dropColumn('files');
        });
    }
}
