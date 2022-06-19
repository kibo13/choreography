<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepsTable extends Migration
{
    public function up()
    {
        Schema::create('reps', function (Blueprint $table) {
            $table->id();
            $table->integer('type_rep')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->bigInteger('doc_id')->unsigned();
            $table->string('doc_num')->nullable();
            $table->date('doc_date')->nullable();
            $table->text('doc_file')->nullable();
            $table->string('doc_note')->nullable();
            $table->text('app_file')->nullable();
            $table->string('app_note')->nullable();
            $table->text('agree_file')->nullable();
            $table->string('agree_note')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reps');
    }
}
