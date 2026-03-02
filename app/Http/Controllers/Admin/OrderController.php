<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Table;
use App\Models\Staff;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // =============================
    // Show Order Details
    // =============================
    public function show(Order $order)
    {
        $order->load(['user', 'table', 'staff', 'orderItems.menuItem']);
        // Simulate timeline and payment fields for demo (replace with real logic if present)
        $order->timeline = [
            'Order placed at ' . $order->created_at->format('d M Y, h:i A'),
            'Status: ' . $order->order_status,
        ];
        $order->payment_status = $order->payment_status ?? 'Unpaid';
        $order->payment_method = $order->payment_method ?? '-';
        $order->notes = $order->notes ?? '-';
        return view('admin.orders.show', compact('order'));
    }
    // =============================
    // Display Orders
    // =============================
    public function index()
    {
        try {
            $orders = Order::with(['user', 'table', 'staff'])
                        ->orderBy('created_at', 'desc')
                        ->get();
            \Log::info('Orders viewed', ['admin_id' => auth()->id()]);
            return view('admin.orders.index', compact('orders'));
        } catch (\Exception $e) {
            \Log::error('Order index failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to load orders. Please try again.');
        }
    }

    // =============================
    // Show Create Form
    // =============================
    public function create()
    {
        try {
            $users  = User::all();
            $tables = Table::all();
            $staff  = Staff::all();
            \Log::info('Order create form viewed', ['admin_id' => auth()->id()]);
            return view('admin.orders.create', compact('users','tables','staff'));
        } catch (\Exception $e) {
            \Log::error('Order create form failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to load order creation form. Please try again.');
        }
    }

    // =============================
    // Store Order
    // =============================
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id'      => 'required|exists:users,id',
                'table_id'     => 'nullable|exists:tables,id',
                'staff_id'     => 'nullable|exists:staff,id',
                'order_type'   => 'required|in:Dine-In,Takeaway,Delivery',
                'order_status' => 'required|in:Pending,Preparing,Completed,Cancelled',
            ]);

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(6)),
                'user_id'      => $request->user_id,
                'table_id'     => $request->table_id,
                'staff_id'     => $request->staff_id,
                'order_type'   => $request->order_type,
                'order_status' => $request->order_status,
            ]);
            \Log::info('Order created', ['order_id' => $order->id, 'admin_id' => auth()->id()]);
            return redirect()->route('admin.orders.index')
                             ->with('success','Order created successfully.');
        } catch (\Exception $e) {
            \Log::error('Order creation failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to create order. Please try again.');
        }
    }

    // =============================
    // Edit Order
    // =============================
    public function edit(Order $order)
    {
        try {
            $users  = User::all();
            $tables = Table::all();
            $staff  = Staff::all();
            \Log::info('Order edit form viewed', ['order_id' => $order->id, 'admin_id' => auth()->id()]);
            return view('admin.orders.edit',
                compact('order','users','tables','staff'));
        } catch (\Exception $e) {
            \Log::error('Order edit form failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to load order edit form. Please try again.');
        }
    }

    // =============================
    // Update Order
    // =============================
    public function update(Request $request, Order $order)
    {
        try {
            $request->validate([
                'user_id'      => 'required|exists:users,id',
                'table_id'     => 'nullable|exists:tables,id',
                'staff_id'     => 'nullable|exists:staff,id',
                'order_type'   => 'required|in:Dine-In,Takeaway,Delivery',
                'order_status' => 'required|in:Pending,Preparing,Completed,Cancelled',
            ]);

            $order->update([
              'order_number' => $request->order_number,
              'user_id'      => $request->user_id,
              'table_id'     => $request->table_id,
              'staff_id'     => $request->staff_id,
              'order_type'   => $request->order_type,
              'order_status' => $request->order_status,
           ]);
           \Log::info('Order updated', ['order_id' => $order->id, 'admin_id' => auth()->id()]);
            return redirect()->route('admin.orders.index')
                             ->with('success','Order updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Order update failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to update order. Please try again.');
        }
    }

    // =============================
    // Delete Order
    // =============================
    public function destroy(Order $order)
    {
        try {
            $order->delete();
            \Log::info('Order deleted', ['order_id' => $order->id, 'admin_id' => auth()->id()]);
            return redirect()->route('admin.orders.index')
                             ->with('success','Order deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Order deletion failed', ['error' => $e->getMessage(), 'admin_id' => auth()->id()]);
            return back()->withErrors('Failed to delete order. Please try again.');
        }
    }
}
