<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservetableController extends Controller
{
    public function index()
    {
        return view('customer.reservation');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'guest_count' => 'required|integer|min:1|max:20',
        ]);

        Reservation::create([
            'user_id' => auth()->id(),
            'table_id' => null, // You can assign later from admin
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'guest_count' => $request->guest_count,
            'special_request' => $request->special_request,
            'status' => 'pending'
        ]);

        return redirect()->route('reservation.success')
            ->with('success', 'Reservation submitted successfully!');
    }

    public function success()
    {
        return view('customer.reservation_success');
    }
}