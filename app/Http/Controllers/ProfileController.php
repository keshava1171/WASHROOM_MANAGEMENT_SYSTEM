<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    
    public function show()
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }

    
    public function update(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'phone'   => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        auth()->user()->update($request->only('name', 'phone', 'address'));
        $user = auth()->user();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Neural Identity synchronized successfully.',
                'updates' => [
                    'user-name' => $user->name,
                    'user-phone' => $user->phone,
                    'user-address' => $user->address,
                    'nav-user-name' => $user->name,
                    'sidebar-user-name' => $user->name,
                ]
            ]);
        }

        return back()->with('success', 'Neural Identity updated successfully.');
    }

    
    public function updateEmail(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        if ($request->email !== $user->email) {

            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->save();

            try {
                $user->sendEmailVerificationNotification();
                $message = 'Verification link dispatched! Please check your new intelligence uplink to synchronize.';
                session()->flash('verification_dispatched', true);
            } catch (\Exception $e) {
                \Log::warning("Verification email failed for {$user->email}: " . $e->getMessage());
                $message = 'Uplink updated, but the verification link could not be sent (SMTP error). Please try regenerating the link.';
            }

            return redirect()->route('verification.notice')->with('success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Target email is identical to current uplink.'], 200);
        }

        return back()->with('info', 'Target email is identical to current intelligence uplink.');
    }

    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Security credentials updated successfully.']);
        }

        return back()->with('success', 'Password updated successfully.');
    }

    
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:5120']
        ]);

        $user = auth()->user();

        if ($request->hasFile('photo')) {

            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('photo')->store('avatars', 'public');
            $user->update(['profile_photo' => $path]);
        }

        return back()->with('success', 'Profile photo updated successfully.');
    }

    
    public function resendVerification(Request $request)
    {
        $user = auth()->user();

        try {
            $user->sendEmailVerificationNotification();
            return back()->with('success', 'Tactical verification signal re-dispatched to ' . $user->email)
                         ->with('verification_dispatched', true);
        } catch (\Exception $e) {
            \Log::warning("Manual verification resend failed for {$user->email}: " . $e->getMessage());
            return back()->with('error', 'Synchronization signal failed to dispatch (SMTP failure).');
        }
    }
}

