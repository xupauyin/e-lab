<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Model\LogActivity;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(){
        $data = [
            'log' => LogActivity::where('lab_id', auth()->user()->lab_id)
            ->orderBy('created_at', 'DESC')
            ->paginate(5)
        ];

        return view ('administrator.log_tabel', $data);
    }
}
