<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountFieldsToMembersTable extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->bigInteger('discount_id')->unsigned()->nullable()->after('form_study');
            $table->text('discount_doc')->nullable()->after('discount_id');
            $table->string('discount_note')->nullable()->after('discount_doc');
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['discount_id', 'discount_doc', 'discount_note']);
        });
    }
}
