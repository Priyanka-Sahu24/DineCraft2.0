<?php

namespace App\Http\Controllers\Staff;

use App\Models\Salary;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    public function index()
    {
        $staff = Auth::user()->staff;
        if (!$staff) {
            return view('staff.salaries.index', [
                'salaries' => collect(),
                'error' => 'Staff profile not found. Please contact admin.'
            ]);
        }
        $salaries = \App\Models\Salary::where('staff_id', $staff->id)
                    ->latest()
                    ->get();

        return view('staff.salaries.index', compact('salaries'));
    }
}