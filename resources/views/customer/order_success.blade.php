@extends('customer.layout')

@section('content')

<div class="container py-5 text-center">

<h2 class="text-success">Order Placed Successfully!</h2>

<p>Your Order ID: <strong>#{{ $order->id }}</strong></p>

<p>Status: {{ $order->order_status }}</p>

<a href="/" class="btn btn-orange mt-3">
Back to Home
</a>

</div>

@endsection