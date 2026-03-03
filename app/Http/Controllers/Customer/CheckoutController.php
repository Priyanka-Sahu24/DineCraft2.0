<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;

class CheckoutController extends Controller
    /**
     * Show all payments for the logged-in customer
     */
    public function myPayments()
    {
        $payments = \App\Models\Payment::whereHas('order', function($q) {
            $q->where('user_id', auth()->id());
        })->with('order')->latest()->get();
        return view('customer.payments', compact('payments'));
    }
{
    /*
    |--------------------------------------------------------------------------
    | Show Checkout Page
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('customer.checkout', compact('cart'));
    }

     public function placeOrder(Request $request)
{
    $request->validate([
        'order_type' => 'required',
        'payment_method' => 'required'
    ]);

    $cart = session()->get('cart');

    if (!$cart) {
        return redirect()->route('cart.index');
    }

    $orderNumber = 'ORD-' . strtoupper(\Illuminate\Support\Str::random(6));


    $order = Order::create([
        'order_number' => $orderNumber,
        'user_id' => auth()->id(),
        'order_type' => $request->order_type,
        'order_status' => 'pending',
        'payment_method' => $request->payment_method,
        'payment_type' => $request->payment_type,
        'payment_status' => $request->payment_method == 'online' ? 'paid' : 'pending',
    ]);

    // Calculate total amount
    $totalAmount = 0;
    foreach ($cart as $id => $item) {
        $totalAmount += $item['price'] * $item['quantity'];
    }

    // Create payment record
    \App\Models\Payment::create([
        'order_id' => $order->id,
        'payment_method' => $request->payment_method,
        'transaction_id' => $request->transaction_id ?? null,
        'payment_status' => $request->payment_method == 'online' ? 'paid' : 'pending',
        'amount' => $totalAmount,
        'paid_at' => $request->payment_method == 'online' ? now() : null,
    ]);

    foreach ($cart as $id => $item) {

        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $id,
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'subtotal' => $item['price'] * $item['quantity'],
        ]);
    }

    session()->forget('cart');

    return redirect()->route('payment.success', $order->id);
}
    public function track($id)
    {
        $order = Order::with('orderItems.menuItem')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('customer.order_track', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | My Orders (Order History)
    |--------------------------------------------------------------------------
    */
    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.my_orders', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel Order
    |--------------------------------------------------------------------------
    */
    public function cancelOrder($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('order_status', 'pending')
            ->findOrFail($id);

        $order->update([
            'order_status' => 'cancelled'
        ]);

        return back()->with('success', 'Order cancelled successfully.');

    }

    public function paymentSuccess($id)
   {
    $order = Order::findOrFail($id);
    return view('customer.payment_success', compact('order'));
   }
}