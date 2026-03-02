<?php

namespace App\Http\Controllers\Admin;

use App\Models\Salary;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = Salary::with('staff.user');

        if ($request->filled('search_name')) {
            $search = $request->search_name;
            $query->whereHas('staff.user', function($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }
        if ($request->filled('filter_staff')) {
            $query->where('staff_id', $request->filter_staff);
        }
        if ($request->filled('filter_month')) {
            $query->where('month', $request->filter_month);
        }
        if ($request->filled('filter_year')) {
            $query->where('year', $request->filter_year);
        }

        $salaries = $query->get();
        $staff = Staff::with('user')->get(); 

        return view('admin.salaries.index', compact('salaries','staff'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'staff_id' => 'required',
                'basic_salary' => 'required|numeric',
                'bonus' => 'nullable|numeric',
                'deduction' => 'nullable|numeric',
                'month' => 'required',
                'year' => 'required'
            ]);

            $net = $request->basic_salary + $request->bonus - $request->deduction;

            $salary = Salary::create([
                'staff_id' => $request->staff_id,
                'basic_salary' => $request->basic_salary,
                'bonus' => $request->bonus ?? 0,
                'deduction' => $request->deduction ?? 0,
                'net_salary' => $net,
                'month' => $request->month,
                'year' => $request->year,
            ]);

            \Log::info('Salary created', ['salary_id' => $salary->id, 'admin_id' => auth()->id()]);

            return back()->with('success','Salary Added Successfully');
        } catch (\Exception $e) {
            \Log::error('Salary creation failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to add salary. Please try again.');
        }
    }

    public function markPaid($id)
    {
        try {
            $salary = Salary::findOrFail($id);
            $salary->update([
                'status' => 'paid',
                'paid_date' => now()
            ]);
            \Log::info('Salary marked as paid', ['salary_id' => $salary->id, 'admin_id' => auth()->id()]);
            return back()->with('success','Salary Marked as Paid');
        } catch (\Exception $e) {
            \Log::error('Mark salary as paid failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to mark salary as paid. Please try again.');
        }
    }
}