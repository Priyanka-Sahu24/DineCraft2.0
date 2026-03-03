<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Salary;

class PaymentController extends Controller
{
    public function index()
    {
        // Fetch all customer payments
        $payments = Payment::with(['order.user'])->get();
        // Fetch all staff salaries
        $salaries = Salary::with('staff')->get();
        // Calculate total revenue

        $totalPayments = $payments->sum('amount');
        $totalSalaries = $salaries->sum('net_salary');
        $totalRevenue = $totalPayments - $totalSalaries;

        return view('admin.payments.index', compact('payments', 'salaries', 'totalRevenue'));
    }
}
