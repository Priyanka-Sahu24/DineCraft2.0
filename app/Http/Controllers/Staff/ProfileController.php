<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $staff = $user->staff;

        return view('staff.profile.index', compact('user', 'staff'));
    }

    public function edit()
    {
        $user = Auth::user();
        $staff = $user->staff;

        return view('staff.profile.edit', compact('user', 'staff'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|min:6|confirmed',
            'shift' => 'required|string'
        ]);

        // Update users table
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // Update staff table
        if ($user->staff) {
            $user->staff->update([
                'shift' => $request->shift
            ]);
        }

        return redirect()->route('staff.profile')
            ->with('success', 'Profile updated successfully.');
    }
}