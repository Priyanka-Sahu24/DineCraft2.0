<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    // Display Staff List
    public function index()
    {
        $query = Staff::with('user');

        if (request()->filled('search_name')) {
            $search = request('search_name');
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }
        if (request()->filled('filter_designation')) {
            $query->where('designation', request('filter_designation'));
        }
        if (request()->filled('filter_status')) {
            $query->where('status', request('filter_status'));
        }

        $staffs = $query->latest()->get();
        return view('admin.staff.index', compact('staffs'));
    }

    // Show Create Form
    public function create()
    {
        return view('admin.staff.create');
    }

    // Store New Staff
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'          => 'required|string|max:255',
                'email'         => 'required|email|unique:users,email',
                'password'      => 'required|min:6|confirmed',
                'employee_id'   => 'required|unique:staff,employee_id',
                'designation'   => 'required|string',
                'salary'        => 'required|numeric',
                'joining_date'  => 'required|date',
                'shift'         => 'required|string',
            ]);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('staff');

            $staff = Staff::create([
                'user_id'       => $user->id,
                'employee_id'   => $request->employee_id,
                'designation'   => $request->designation,
                'salary'        => $request->salary,
                'joining_date'  => $request->joining_date,
                'shift'         => $request->shift,
                'status'        => 'active'
            ]);

            \Log::info('Staff created', ['staff_id' => $staff->id, 'admin_id' => auth()->id()]);

            return redirect()
                ->route('admin.staff.index')
                ->with('success', 'Staff added successfully!');
        } catch (\Exception $e) {
            \Log::error('Staff creation failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to add staff. Please try again.');
        }
    }

    // Show Edit Form
    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    // Update Staff
    public function update(Request $request, Staff $staff)
    {
        try {
            $request->validate([
                'name'          => 'required|string|max:255',
                'email'         => 'required|email|unique:users,email,' . $staff->user->id,
                'employee_id'   => 'required|unique:staff,employee_id,' . $staff->id,
                'designation'   => 'required|string',
                'salary'        => 'required|numeric',
                'joining_date'  => 'required|date',
                'shift'         => 'required|string',
                'status'        => 'required|string',
            ]);

            $staff->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            $staff->update([
                'employee_id'   => $request->employee_id,
                'designation'   => $request->designation,
                'salary'        => $request->salary,
                'joining_date'  => $request->joining_date,
                'shift'         => $request->shift,
                'status'        => $request->status,
            ]);

            \Log::info('Staff updated', ['staff_id' => $staff->id, 'admin_id' => auth()->id()]);

            return redirect()
                ->route('admin.staff.index')
                ->with('success', 'Staff updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Staff update failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to update staff. Please try again.');
        }
    }

    // Delete Staff
    public function destroy(Staff $staff)
    {
        try {
            if ($staff->user) {
                $staff->user->removeRole('staff');
                $staff->user->delete();
            }
            $staff->delete();
            \Log::info('Staff deleted', ['staff_id' => $staff->id, 'admin_id' => auth()->id()]);
            return redirect()
                ->route('admin.staff.index')
                ->with('success', 'Staff deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Staff deletion failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to delete staff. Please try again.');
        }
    }
}