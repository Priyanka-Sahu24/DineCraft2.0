<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;

class ReservationController extends Controller
{
    // =============================
    // Display Reservations
    // =============================
    public function index()
    {
        $reservations = Reservation::with(['user', 'table'])
            ->orderBy('reservation_date', 'desc')
            ->orderBy('reservation_time', 'desc')
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    // =============================
    // Show Create Form
    // =============================
    public function create()
    {
        $users  = User::all();
        $tables = Table::where('status', 'available')->get();

        return view('admin.reservations.create', compact('users', 'tables'));
    }

    // =============================
    // Store Reservation
    // =============================
    public function store(Request $request)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'table_id'         => 'required|exists:tables,id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'guest_count'      => 'required|integer|min:1',
            'special_request'  => 'nullable|string'
        ]);

        $reservation = Reservation::create([
            'user_id'          => $request->user_id,
            'table_id'         => $request->table_id,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'guest_count'      => $request->guest_count,
            'special_request'  => $request->special_request,
            'status'           => 'pending',
        ]);

        return redirect()
            ->route('admin.reservations.index')
            ->with('success', 'Reservation created successfully.');
    }

    // =============================
    // Edit Reservation
    // =============================
    public function edit(Reservation $reservation)
    {
        $users  = User::all();
        $tables = Table::all();

        return view('admin.reservations.edit',
            compact('reservation', 'users', 'tables'));
    }

    // =============================
    // Update Reservation
    // =============================
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'table_id'         => 'required|exists:tables,id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'guest_count'      => 'required|integer|min:1',
            'special_request'  => 'nullable|string'
        ]);

        $reservation->update([
            'user_id'          => $request->user_id,
            'table_id'         => $request->table_id,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'guest_count'      => $request->guest_count,
            'special_request'  => $request->special_request,
        ]);

        return redirect()
            ->route('admin.reservations.index')
            ->with('success', 'Reservation updated successfully.');
    }

    // =============================
    // Update Status (Like Staff)
    // =============================
    public function updateStatus($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status == 'pending') {

            $reservation->status = 'confirmed';

        } elseif ($reservation->status == 'confirmed') {

            $reservation->status = 'completed';

            // Occupy table
            if ($reservation->table) {
                $reservation->table->status = 'occupied';
                $reservation->table->save();
            }

        } elseif ($reservation->status == 'completed') {

            // Free table after completion
            if ($reservation->table) {
                $reservation->table->status = 'available';
                $reservation->table->save();
            }

            $reservation->status = 'completed';
        }

        $reservation->save();

        return back()->with('success', 'Reservation status updated successfully.');
    }

    // =============================
    // Cancel Reservation
    // =============================
    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->status = 'cancelled';
        $reservation->save();

        if ($reservation->table) {
            $reservation->table->status = 'available';
            $reservation->table->save();
        }

        return back()->with('success', 'Reservation cancelled successfully.');
    }

    // =============================
    // Delete Reservation
    // =============================
    public function destroy(Reservation $reservation)
    {
        // Free table if deleting active reservation
        if ($reservation->table) {
            $reservation->table->status = 'available';
            $reservation->table->save();
        }

        $reservation->delete();

        return redirect()
            ->route('admin.reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }
}