<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $table = 'log_activities';
    protected $primaryKey = 'log_id';
    protected $fillable = ['nama', 'ip', 'browser', 'method', 'menu', 'status', 'keterangan', 'lab_id'];
}
