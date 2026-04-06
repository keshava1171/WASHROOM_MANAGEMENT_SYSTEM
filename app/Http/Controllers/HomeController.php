<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Complaint;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isStaff()) {
            return redirect()->route('staff.dashboard');
        } else {

            $userComplaints = Complaint::where('user_id', $user->id)
                ->with(['floor', 'room', 'washroom'])
                ->latest()
                ->get();
                
            return view('user.dashboard', compact('userComplaints'));
        }
    }
}

