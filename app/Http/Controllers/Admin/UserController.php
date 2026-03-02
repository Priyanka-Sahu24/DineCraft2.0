<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%") ;
            });
        }
        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->input('role'));
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        $users = $query->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // Add stubs for show, edit, update, destroy, create, store
    public function show(User $user) {
        return view('admin.users.show', compact('user'));
    }
    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }
    public function update(Request $request, User $user) {
        // ... update logic ...
        return back()->with('success', 'User updated.');
    }
    public function destroy(User $user) {
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
    public function create() {
        return view('admin.users.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'status' => 'active',
        ]);
        $user->assignRole($request->role);

        // Automatically create staff profile if role is staff
        if ($request->role === 'staff') {
            $latestStaffId = \App\Models\Staff::max('id') ?? 0;
            \App\Models\Staff::create([
                'user_id' => $user->id,
                'employee_id' => 'EMP' . str_pad($latestStaffId + 1, 4, '0', STR_PAD_LEFT),
                'designation' => 'waiter', // default, can be edited later
                'salary' => 0,
                'joining_date' => now()->toDateString(),
                'shift' => 'morning', // default
                'status' => 'active',
            ]);
        }

        // Optionally send credentials to user or notify

        // After creation, user can log in and will be redirected based on their role
        // (handled in AuthController)

        return redirect()->route('admin.users.index')->with('success', 'User created with role-based access.');
    }
}
