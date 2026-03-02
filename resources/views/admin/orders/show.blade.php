@extends('admin.layouts.admin')
@section('title','Order Details')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-orange">Order Details</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mb-3">Back to Orders</a>
    <div class="card mb-4">
        <div class="card-body">
            <h5>Order #{{ $order->order_number }}</h5>
            <p><strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }}</p>
            <p><strong>Table:</strong> {{ $order->table->table_number ?? '-' }}</p>
            <p><strong>Staff:</strong> {{ $order->staff->employee_id ?? '-' }}</p>
            <p><strong>Order Type:</strong> {{ $order->order_type }}</p>
            <p><strong>Status:</strong> <span class="badge bg-{{ $order->order_status == 'Completed' ? 'success' : ($order->order_status == 'Preparing' ? 'warning text-dark' : ($order->order_status == 'Pending' ? 'info' : 'danger')) }}">{{ $order->order_status }}</span></p>
            <p><strong>Created At:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-light">Order Items</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->menuItem->name ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹ {{ $item->price }}</td>
                        <td>₹ {{ $item->subtotal }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mb-3">
        <strong>Total:</strong> ₹ {{ $order->orderItems->sum('subtotal') }}
    </div>
    <div class="mb-3">
        <strong>Payment Status:</strong> <span class="badge bg-{{ $order->payment_status == 'Paid' ? 'success' : 'danger' }}">{{ $order->payment_status ?? 'Unpaid' }}</span>
    </div>
    <div class="mb-3">
        <strong>Payment Method:</strong> {{ $order->payment_method ?? '-' }}
    </div>
    <div class="mb-3">
        <strong>Notes:</strong> {{ $order->notes ?? '-' }}
    </div>
    <div class="mb-3">
        <strong>Order Timeline:</strong>
        <ul>
            @foreach($order->timeline ?? [] as $log)
                <li>{{ $log }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
