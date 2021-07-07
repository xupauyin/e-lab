<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal', function (Blueprint $table) {
            $table->increments('jurnal_id');
            $table->text('uraian_kgt');
            $table->string('waktu_jurnal',20);
            $table->text('ctt_pihak');
            $table->string('status_verifikasi',50)->default('BELUM DIVERIFIKASI');
            $table->unsignedBigInteger('lab_id');
            $table->foreign('lab_id')->references('laboratorium_id')->on('laboratorium');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
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
        Schema::dropIfExists('jurnals');
    }
}
