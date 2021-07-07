<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->increments('inventaris_id');
            $table->string('nama_brg',100);
            $table->string('kondisi_brg',20);
            $table->text('keterangan');
            $table->text('spesifikasi_brg');
            $table->string('tahun_beli',4);
            $table->string('kode_brg',100);
            $table->string('kode_sarpras',100);
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
        Schema::dropIfExists('inventaris');
    }
}
