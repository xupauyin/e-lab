<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->increments('maintenance_id');
            $table->text('penanganan_hard');
            $table->text('penanganan_soft');
            $table->string('kondisi_hard',20);
            $table->string('kondisi_soft',20);
            $table->string('nama_kom',20);
            $table->text('spesifikasi_hard');
            $table->text('spesifikasi_soft');
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
        Schema::dropIfExists('maintenances');
    }
}
