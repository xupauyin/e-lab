<?php

use App\Model\LogActivity;

function userlog($status = null, $keterangan = null)
{
    $data = [
        'nama' => auth()->user()->name,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'browser' => request()->header('User-Agent'),
        'method' => request()->method(),
        'menu' => request()->segment(count(request()->segments())),
        'status' => $status,
        'keterangan' => $keterangan,
        'lab_id' => auth()->user()->lab_id, 
        'created_at' => date('Y-m-d h:i:s')
    ];

    LogActivity::create($data);
}
