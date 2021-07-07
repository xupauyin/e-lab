<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintenance extends Model
{
    use SoftDeletes;

    protected $table = 'maintenance';
    protected $primaryKey = 'maintenance_id';
    protected $fillable = ['penanganan_hard','penanganan_soft','kondisi_hard', 'kondisi_soft', 'nama_kom', 
    'spesifikasi_hard', 'spesifikasi_soft', 'status_verifikasi', 'lab_id', 'user_id', 'deleted_at', 'created_at','updated_at'];
}
