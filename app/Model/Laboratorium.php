<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laboratorium extends Model
{
    use SoftDeletes;

    protected $table = 'laboratorium';
    protected $primaryKey = 'laboratorium_id';
    protected $fillable = ['nama_laboratorium', 'prodi', 'deleted_at', 'created_at','updated_at'];
}
