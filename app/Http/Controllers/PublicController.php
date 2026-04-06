<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Washroom;

class PublicController extends Controller
{
    
    public function home()
    {
        return view('public.home');
    }

    
    public function washrooms()
    {
        $washrooms = Washroom::with('floor')->get();
        return view('public.washrooms', compact('washrooms'));
    }
}

