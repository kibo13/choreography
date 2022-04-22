<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->bigInteger('role_id')->unsigned();
            $table->rememberToken();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->tinyInteger('doc_type')->nullable();
            $table->string('doc_num')->unique()->nullable();
            $table->date('doc_date')->nullable();
            $table->date('birthday')->nullable();
            $table->tinyInteger('age')->nullable();
            $table->text('address_doc')->nullable();
            $table->string('address_note')->nullable();
            $table->string('address_fact')->nullable();
            $table->string('activity')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
