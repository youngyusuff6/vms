<?php

namespace App\Http\Controllers\Dashboard\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SecurityDashboardController extends Controller
{
    public function index(){
        return view('dashboard.security.dashboard');
    }
}
