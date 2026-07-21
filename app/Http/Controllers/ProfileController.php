<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show profile page.
     */
    public function edit()
    {
        return view('frontend.profile', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update profile information and password.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate Name & Email
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Update Name & Email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update Password (Only if user entered one)
        if ($request->filled('new_password')) {

            $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => [
                    'required',
                    'confirmed',
                    Password::defaults(),
                    'different:current_password',
                ],
            ], [
                'current_password.current_password' => 'Current password is incorrect.',
                'new_password.different' => 'New password must be different from current password.',
            ]);

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}