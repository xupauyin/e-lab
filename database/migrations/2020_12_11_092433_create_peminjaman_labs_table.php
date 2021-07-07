<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjamanlab', function (Blueprint $table) {
            $table->increments('peminjamanlab_id');
            $table->string('nama_pl',100);
            $table->string('unit_pl',100);
            $table->dateTime('tgl_req');
            $table->text('keperluan_pl');
            $table->string('nama_lab',100);
            $table->string('status_verifikasi',50)->default('BELUM DIVERIFIKASI');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();  
            $table->timestamps();

            $table->unsignedBigInteger('lab_id');
            $table->foreign('lab_id')->references('laboratorium_id')->on('laboratorium');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjaman_labs');
    }
}
