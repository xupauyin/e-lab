<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventaris extends Model
{
    use SoftDeletes;

    protected $table = 'inventaris';
    protected $primaryKey = 'inventaris_id';
    protected $fillable = ['nama_brg', 'kondisi_brg','keterangan', 'spesifikasi_brg', 'tahun_beli', 'kode_brg', 
    'kode_sarpras', 'status_verifikasi', 'user_id', 'lab_id', 'deleted_at', 'created_at','updated_at'];
}
