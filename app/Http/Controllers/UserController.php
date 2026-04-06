<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function dashboard()
    {
        $user = Auth::user();
        

        $stats = [
            'total'    => Complaint::where('user_id', $user->id)->count(),
            'pending'  => Complaint::where('user_id', $user->id)->where('status', 'pending')->count(),
            'resolved' => Complaint::where('user_id', $user->id)->where('status', 'resolved')->count(),
        ];

        $userComplaints = Complaint::with(['floor', 'room', 'washroom'])
            ->where('user_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        return view('user.dashboard', compact('stats', 'userComplaints'));
    }
}
