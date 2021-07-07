<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeminjamanLab extends Model
{
    use SoftDeletes;

    protected $table = 'peminjamanlab';
    protected $primaryKey = 'peminjamanlab_id';
    protected $fillable = ['nama_pl', 'unit_pl', 'tgl_req','keperluan_pl', 'nama_lab', 
    'status_verifikasi', 'lab_id', 'user_id', 'deleted_at', 'created_at','updated_at'];
}
