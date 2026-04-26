<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectToRoleDashboard(Auth::user());
        }
        return view('auth.login');
    }

    /**
     * Staff welcome email entry point.
     * Clears any existing session (e.g. admin testing the link while logged in),
     * then redirects to the standard login page with a helpful message.
     */
    public function showStaffLogin(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')
            ->with('info', 'Please sign in with your staff credentials to access the Staff Portal.');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectToRoleDashboard(Auth::user());
        }
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (method_exists($user, 'updateLastLogin')) {
                $user->updateLastLogin();
            }

            return $this->redirectToRoleDashboard($user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'user',
        ]);

        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Registration successful! Please check your email for a verification link.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }

    public function showVerification()
    {
        return view('auth.verify');
    }

    public function verifyEmail(Request $request)
    {
        $user = $request->user();

        // If already verified, go straight to their dashboard.
        if ($user->hasVerifiedEmail()) {
            return $this->redirectToRoleDashboard($user);
        }

        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        // After email change verification, ALL roles must re-login with their new
        // email address so the session is completely fresh.
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Email verified successfully! Please sign in with your new email address to continue.');
    }

    public function resendVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent! Please check your inbox.');
    }

    // NOTE: Email update from the verify page is handled by ProfileController::updateEmail()
    // to avoid duplicate verification emails. The route 'verification.update_email'
    // now points to ProfileController@updateEmail.

    private function redirectToRoleDashboard($user)
    {
        if ($user->role === 'admin' || $user->role === 'staff') {
            
            // Redirect to profile if first-time login (must change password).
            // This covers both the default admin (must_change_password=true) and new staff accounts.
            if ($user->must_change_password) {
                $msg = 'Authentication successful! Security protocols require you to update your password and profile details now.';
                return redirect()->route('profile.edit')->with('info', $msg);
            }
            
            return redirect()->route($user->role . '.dashboard');
        }

        return redirect()->route('dashboard')->with('success', 'Tactical node access granted. Welcome to the WMS Command Interface.');
    }
}

