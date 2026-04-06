<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('auth.change-password');
    }

    public function change(Request $request)
    {
        $request->validate([
            'password'              => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        $user = auth()->user();
        $user->password             = Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect()->intended(
            $user->role === 'admin' ? '/admin/dashboard' : '/staff/dashboard'
        )->with('success', 'Password updated successfully! Welcome.');
    }
}

