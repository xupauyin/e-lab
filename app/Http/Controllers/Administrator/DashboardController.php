<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {   
        return view('administrator.home');
    }
}
