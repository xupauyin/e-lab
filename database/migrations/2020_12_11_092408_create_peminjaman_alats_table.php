<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanAlatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjamanalat', function (Blueprint $table) {
            $table->increments('peminjamanalat_id');
            $table->string('peminjam',100);
            $table->string('lmb_peminjam',100);
            $table->string('kondisi_pjm',5);
            $table->string('pengembali',100)->nullable();
            $table->date('tgl_kembali')->nullable();
            $table->string('kondisi_blk',5)->nullable();
            $table->string('nama_alat',50);
            $table->string('kode_alat',20);
            $table->string('jumlah',11);
            $table->string('lama',20);
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
        Schema::dropIfExists('peminjaman_alats');
    }
}
