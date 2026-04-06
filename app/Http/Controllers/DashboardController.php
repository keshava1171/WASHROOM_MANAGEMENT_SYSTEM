<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Washroom;
use App\Models\Complaint;
use App\Models\CleaningSchedule;
use App\Models\Maintenance;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_washrooms' => Washroom::count(),
            'clean_count' => Washroom::where('status', 'Clean')->count(),
            'dirty_count' => Washroom::where('status', 'Dirty')->count(),
            'maintenance_count' => Washroom::where('status', 'Maintenance')->count(),
            'pending_complaints' => Complaint::count(),
            'active_maintenance' => Maintenance::where('status', '!=', 'Completed')->count(),
        ];

        $recent_complaints = Complaint::with('washroom')->latest()->take(5)->get();
        
        return view('dashboard', compact('stats', 'recent_complaints'));
    }
}

