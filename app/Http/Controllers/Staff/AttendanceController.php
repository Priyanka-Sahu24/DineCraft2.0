<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $staff = Staff::where('user_id', Auth::id())->first();
        if (!$staff) {
            // Auto-create staff profile if missing
            $user = Auth::user();
            $latestStaffId = Staff::max('id') ?? 0;
            $staff = Staff::create([
                'user_id' => $user->id,
                'employee_id' => 'EMP' . str_pad($latestStaffId + 1, 4, '0', STR_PAD_LEFT),
                'designation' => 'waiter', // default
                'salary' => 0,
                'joining_date' => now()->toDateString(),
                'shift' => 'morning',
                'status' => 'active',
            ]);
        }
        $attendances = Attendance::where('staff_id', $staff->id)
            ->orderBy('date', 'desc')
            ->get();
        return view('staff.attendance.index', compact('attendances'));
    }

    public function mark()
    {
        $staff = Staff::where('user_id', Auth::id())->first();
        if (!$staff) {
            // Auto-create staff profile if missing
            $user = Auth::user();
            $latestStaffId = Staff::max('id') ?? 0;
            $staff = Staff::create([
                'user_id' => $user->id,
                'employee_id' => 'EMP' . str_pad($latestStaffId + 1, 4, '0', STR_PAD_LEFT),
                'designation' => 'waiter', // default
                'salary' => 0,
                'joining_date' => now()->toDateString(),
                'shift' => 'morning',
                'status' => 'active',
            ]);
        }

        $today = date('Y-m-d');
        $exists = Attendance::where('staff_id', $staff->id)
            ->where('date', $today)
            ->first();
        if ($exists) {
            return back()->with('error', 'Attendance already marked today.');
        }
        $istNow = now()->setTimezone('Asia/Kolkata');
        Attendance::create([
            'staff_id' => $staff->id,
            'date' => $today,
            'status' => 'present',
            'check_in' => $istNow->format('H:i:s'),
        ]);
        return back()->with('success', 'Attendance marked successfully at ' . $istNow->format('H:i:s') . ' IST.');

    }

    public function logoutAttendance()
    {
        $staff = Staff::where('user_id', Auth::id())->first();
        $today = date('Y-m-d');
        $attendance = Attendance::where('staff_id', $staff->id)
            ->where('date', $today)
            ->first();
        if ($attendance && !$attendance->check_out) {
            $istNow = now()->setTimezone('Asia/Kolkata');
            $attendance->check_out = $istNow->format('H:i:s');
            $attendance->save();
            return back()->with('success', 'Logged out at ' . $attendance->check_out . ' IST.');
        }
        return back()->with('error', 'Attendance not found or already logged out.');
    }
}