<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    public function index()
    {
        return view('laboran.home');
    }
}
