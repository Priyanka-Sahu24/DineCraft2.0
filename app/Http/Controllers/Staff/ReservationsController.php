<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['table','user'])
            ->orderBy('reservation_date')
            ->orderBy('reservation_time')
            ->get();

        return view('staff.reservations.index', compact('reservations'));
    }

    public function updateStatus($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status == 'pending') {
            $reservation->status = 'confirmed';
        } elseif ($reservation->status == 'confirmed') {
            $reservation->status = 'completed';

            // Update table status to occupied
            if ($reservation->table) {
                $reservation->table->status = 'occupied';
                $reservation->table->save();
            }

        } elseif ($reservation->status == 'completed') {
            $reservation->status = 'completed';

            // Free the table
            if ($reservation->table) {
                $reservation->table->status = 'available';
                $reservation->table->save();
            }
        }

        $reservation->save();

        return back()->with('success', 'Reservation status updated successfully.');
    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->status = 'cancelled';
        $reservation->save();

        if ($reservation->table) {
            $reservation->table->status = 'available';
            $reservation->table->save();
        }

        return back()->with('success', 'Reservation cancelled.');
    }
}