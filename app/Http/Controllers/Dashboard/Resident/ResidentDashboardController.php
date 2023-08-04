<?php

namespace App\Http\Controllers\Dashboard\Resident;

use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ResidentDashboardController extends Controller
{    
    public function index()
    {
        // Get the current logged-in user's ID (resident ID)
        $residentId = Auth::id();
    
        // Get data for the dashboard
        $visitorsToday = Visitor::where('resident_id', $residentId)
            ->whereDate('created_at', today())
            ->count();
        $totalVisitors = Visitor::where('resident_id', $residentId)->count();
        $visitorsPercentage = $totalVisitors > 0 ? ($visitorsToday / $totalVisitors) * 100 : 0;
    
        // Count pending validation and rejected visitors for the current resident
        $pendingValidation = Visitor::where('resident_id', $residentId)
            ->where('status', 'Pending')
            ->where('reg_type', 'reg')
            ->count();
        $rejectedVisitors = Visitor::where('resident_id', $residentId)
            ->where('status', 'Rejected')
            ->count();
    
        // Chart data to pass to the view using with()
        $chartData = [
            'visitorsToday' => $visitorsToday,
            'totalVisitors' => $totalVisitors,
            'visitorsPercentage' => $visitorsPercentage,
            'pendingValidation' => $pendingValidation,
            'rejectedVisitors' => $rejectedVisitors,
        ];
    
        // Pass the chart data and other data to the view using with()
        return view('dashboard.resident.dashboard')
            ->with([
                'chartData' => $chartData,
                'visitorsToday' => $visitorsToday,
                'totalVisitors' => $totalVisitors,
                'visitorsPercentage ' => $visitorsPercentage,
                'pendingValidation ' => $pendingValidation, 
                'rejectedVisitors ' => $rejectedVisitors, 
            ]);
    }
    
}
