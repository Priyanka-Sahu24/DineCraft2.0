@extends('customer.layout')

@section('content')

<div class="container py-5">

<h2 class="text-orange fw-bold">Order Tracking</h2>

<div class="card p-4 shadow-sm">

<h5>Order Number: {{ $order->order_number }}</h5>
<p>Status: 
    <span class="badge bg-warning text-dark">
        {{ ucfirst($order->order_status) }}
    </span>
</p>

<hr>

<h5>Items:</h5>

@foreach($order->orderItems as $item)
<p>
{{ $item->menuItem->name }} x {{ $item->quantity }}
<span class="float-end">
₹ {{ $item->subtotal }}
</span>
</p>
@endforeach

</div>

</div>

@endsection