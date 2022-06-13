<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialtyWorkerTable extends Migration
{
    public function up()
    {
        Schema::create('specialty_worker', function (Blueprint $table) {
            $table->bigInteger('specialty_id')->unsigned();
            $table->bigInteger('worker_id')->unsigned();
            $table->foreign('specialty_id')
                ->references('id')
                ->on('specialties')
                ->onDelete('cascade');
            $table->foreign('worker_id')
                ->references('id')
                ->on('workers')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('specialty_worker');
    }
}
