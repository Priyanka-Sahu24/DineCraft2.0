<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Models\Order;

class StaffOrderController extends Controller
{
    public function index()
    {
        $staffId = auth()->user()->staff->id;

        $orders = Order::with(['table', 'items.menuItem'])
                        ->where('staff_id', $staffId)
                        ->latest()
                        ->get();

        return view('staff.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $staffId = auth()->user()->staff->id;

        if ($order->staff_id != $staffId) {
            abort(403);
        }

        $user = auth()->user();

        if ($user->hasRole('chef')) {
            $allowed = ['Pending', 'Preparing', 'Ready'];
        } elseif ($user->hasRole('waiter')) {
            $allowed = ['Ready', 'Served'];
        } elseif ($user->hasRole('cashier')) {
            $allowed = ['Served', 'Completed'];
        } elseif ($user->hasRole('delivery')) {
            $allowed = ['Assigned', 'On The Way', 'Delivered'];
        } else {
            $allowed = [];
        }

        if (!in_array($request->order_status, $allowed)) {
            return back()->with('error', 'Invalid status change');
        }

        $order->update([
            'order_status' => $request->order_status
        ]);

        return back()->with('success', 'Order status updated successfully');
    }
}
