<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id('log_id');
            $table->string('nama');
            $table->string('ip');
            $table->text('browser');
            $table->string('method');
            $table->string('menu');
            $table->string('status');
            $table->string('keterangan');
            $table->unsignedBigInteger('lab_id');
            $table->foreign('lab_id')->references('laboratorium_id')->on('laboratorium');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_activities');
    }
}
