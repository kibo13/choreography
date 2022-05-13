<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileFieldsToMembersTable extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->text('doc_file')->nullable()->after('doc_date');
            $table->string('doc_note')->nullable()->after('doc_file');
            $table->text('app_file')->nullable()->after('doc_note');
            $table->string('app_note')->nullable()->after('app_file');
            $table->text('consent_file')->nullable()->after('app_note');
            $table->string('consent_note')->nullable()->after('consent_file');
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'doc_file', 'doc_note',
                'app_file', 'app_note',
                'consent_file', 'consent_note'
            ]);
        });
    }
}
