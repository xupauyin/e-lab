<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeminjamanAlat extends Model
{
    use SoftDeletes;

    protected $table = 'peminjamanalat';
    protected $primaryKey = 'peminjamanalat_id';
    protected $fillable = ['peminjam', 'lmb_peminjam', 'kondisi_pjm', 'pengembali', 'tgl_kembali', 
    'kondisi_blk', 'nama_alat', 'kode_alat', 'jumlah', 'lama', 'status_verifikasi', 'lab_id', 'user_id', 'deleted_at', 'created_at','updated_at'];
}
