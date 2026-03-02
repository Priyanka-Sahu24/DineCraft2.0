<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $staff = Auth::user()->staff;
        if (!$staff) {
            return view('staff.leaves.index', [
                'leaves' => collect(),
                'leaveBalance' => ['sick'=>0,'paid'=>0,'casual'=>0],
                'error' => 'Staff profile not found. Please contact admin.'
            ]);
        }
        $leaves = \App\Models\Leave::where('staff_id', $staff->id)
                       ->latest()
                       ->get();
        // Dummy leave balance for now
        $leaveBalance = [
            'sick' => 5,
            'paid' => 10,
            'casual' => 7
        ];
        return view('staff.leaves.index', compact('leaves', 'leaveBalance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
            'reason'    => 'required'
        ]);

        Leave::create([
            'staff_id' => Auth::user()->staff->id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        return back()->with('success','Leave Applied Successfully');
    }
}