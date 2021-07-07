<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurnal extends Model
{
    use SoftDeletes;

    protected $table = 'jurnal';
    protected $primaryKey = 'jurnal_id';
    protected $fillable = ['uraian_kgt', 'waktu_jurnal','ctt_pihak', 'status_verifikasi', 'lab_id',
     'user_id', 'deleted_at','created_at','updated_at'];
}
