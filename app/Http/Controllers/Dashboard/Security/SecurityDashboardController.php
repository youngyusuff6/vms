<?php

namespace App\Http\Controllers\Dashboard\Security;

use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SecurityDashboardController extends Controller
{
    public function index()
    {
        // Get the current logged-in user's role
        $userRole = Auth::user()->role;
        
        // Initialize variables for tab data
        $totalVisitors = 0;
        $visitorsToday = 0;
        $visitorsRegisteredByMe = 0;
    
        // Logic for "Total Visitors" tab
        if ($userRole === 'security') {
            // For security users, count total visitors registered by all residents
            $totalVisitors = Visitor::count();
        }
    
        // Logic for "Visitors Today" tab
        $visitorsToday = Visitor::whereDate('created_at', today())->count();
    
        // Logic for "Visitors Registered by Me" tab
        if ($userRole === 'security') {
            // For security users, count total visitors registered by the currently logged-in user
            $visitorsRegisteredByMe = Visitor::where('registered_by', Auth::id())->count();
        }
    
        // Prepare the chart data (you can update this based on your specific chart requirements)
        $chartData = [
            'totalVisitors' => $totalVisitors,
            'visitorsToday' => $visitorsToday,
            'visitorsRegisteredByMe' => $visitorsRegisteredByMe,
        ];
    
        // Pass the data to the view
        return view('dashboard.security.dashboard', compact('chartData'));
    }
    
}
