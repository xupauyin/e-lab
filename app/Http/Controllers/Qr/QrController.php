<?php

namespace App\Http\Controllers\Qr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function qrlink($id)
    {
        session()->put('qrdata', $id);
    } 
}
