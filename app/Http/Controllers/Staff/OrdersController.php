<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items','table'])
            ->where('staff_id', Auth::id())
            ->latest()
            ->get();

        return view('staff.orders.index', compact('orders'));
    }

    public function updateStatus($id)
    {
        $order = Order::where('id', $id)
            ->where('staff_id', Auth::id())
            ->firstOrFail();

        if ($order->order_status == 'pending') {
            $order->order_status = 'preparing';
        } elseif ($order->order_status == 'preparing') {
            $order->order_status = 'ready';
        } elseif ($order->order_status == 'ready') {
            $order->order_status = 'served';
        }

        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
    public function active()
{
    $orders = Order::with(['items','table'])
        ->where('staff_id', auth()->id())
        ->whereIn('order_status', ['pending','preparing'])
        ->latest()
        ->get();

    return view('staff.orders.active', compact('orders'));
}
}