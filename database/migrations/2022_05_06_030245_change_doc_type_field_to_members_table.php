<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDocTypeFieldToMembersTable extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->bigInteger('doc_id')->unsigned()->after('middle_name');
            $table->dropColumn('doc_type');
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->tinyInteger('doc_type')->after('middle_name');
            $table->dropColumn('doc_id');
        });
    }
}
