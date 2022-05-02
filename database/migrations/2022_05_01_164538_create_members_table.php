<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->tinyInteger('doc_type');
            $table->string('doc_num')->unique();
            $table->date('doc_date');
            $table->date('birthday');
            $table->tinyInteger('age');
            $table->text('address_doc')->nullable();
            $table->string('address_note')->nullable();
            $table->string('address_fact')->nullable();
            $table->string('activity')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
}
