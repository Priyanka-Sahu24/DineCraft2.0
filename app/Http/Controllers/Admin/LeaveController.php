<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::with('staff')->latest()->get();
        return view('admin.leaves.index', compact('leaves'));
    }

    public function approve($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->update(['status' => 'approved']);

        return back()->with('success','Leave Approved');
    }

    public function reject($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->update(['status' => 'rejected']);

        return back()->with('success','Leave Rejected');
    }
}