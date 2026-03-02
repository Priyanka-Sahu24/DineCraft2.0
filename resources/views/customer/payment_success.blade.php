@extends('customer.layout')

@section('content')

<div class="container text-center py-5">

<h1 class="text-success">Payment Successful 🎉</h1>

<p class="mt-3">
Your Order <strong>{{ $order->order_number }}</strong>
has been placed successfully.
</p>

<a href="{{ route('order.track',$order->id) }}"
class="btn btn-orange mt-4">
Track Order
</a>

</div>

@endsection