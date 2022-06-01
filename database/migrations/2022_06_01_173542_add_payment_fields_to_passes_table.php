<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentFieldsToPassesTable extends Migration
{
    public function up()
    {
        Schema::table('passes', function (Blueprint $table) {
            $table->date('pay_date')->nullable()->after('status');
            $table->text('pay_file')->nullable()->after('pay_date');
            $table->string('pay_note')->nullable()->after('pay_file');
        });
    }

    public function down()
    {
        Schema::table('passes', function (Blueprint $table) {
            $table->dropColumn(['pay_date', 'pay_file', 'pay_note']);
        });
    }
}
