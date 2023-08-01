<?php

namespace App\Http\Controllers\Dashboard\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResidentDashboardController extends Controller
{
    public function index(){
        return view('dashboard.resident.dashboard');
    }
}
