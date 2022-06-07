<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionFieldToWorkersTable extends Migration
{
    public function up()
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->string('position')->nullable()->after('middle_name');
        });
    }

    public function down()
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
}
