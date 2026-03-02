@extends('customer.layout')

@section('content')

<div class="container py-5">

<h2 class="fw-bold text-orange mb-4">Checkout</h2>

<form method="POST" action="{{ route('place.order') }}">
@csrf

<div class="row">

<!-- LEFT SIDE -->
<div class="col-md-7">

<div class="card shadow-lg p-4 mb-4">

<h5 class="fw-bold mb-3">Billing Details</h5>

<input type="text" class="form-control mb-3"
value="{{ auth()->user()->name }}" readonly>

<input type="email" class="form-control mb-3"
value="{{ auth()->user()->email }}" readonly>

<input type="text" class="form-control mb-3"
value="{{ auth()->user()->phone }}" readonly>

<textarea class="form-control mb-3" rows="3" readonly>{{ auth()->user()->address }}</textarea>

<h5 class="fw-bold mt-4">Order Type</h5>

<select name="order_type" class="form-control mb-4" required>
<option value="Delivery">Delivery</option>
<option value="Dine-in">Dine-in</option>
</select>

<h5 class="fw-bold">Payment Method</h5>

<div class="border rounded p-3 mb-3">

<div class="form-check mb-2">
<input class="form-check-input" type="radio"
name="payment_method" value="cod" checked>
<label class="form-check-label fw-semibold">
Cash on Delivery
</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio"
name="payment_method" value="online">
<label class="form-check-label fw-semibold">
Online Payment (UPI / QR)
</label>
</div>

</div>

<!-- ONLINE PAYMENT SECTION -->
<div id="onlineSection" style="display:none;" class="card p-3">

<h6 class="fw-bold">Scan & Pay</h6>

<p class="text-muted">UPI ID: dinecraft@upi</p>

<img src="{{ asset('images/qr.png') }}"
width="200"
class="img-fluid border rounded p-2">

<select name="payment_type" class="form-control mt-3">
<option value="">Select App</option>
<option value="gpay">Google Pay</option>
<option value="phonepe">PhonePe</option>
<option value="paytm">Paytm</option>
<option value="upi">Other UPI</option>
</select>

</div>

</div>
</div>

<!-- RIGHT SIDE -->
<div class="col-md-5">

<div class="card shadow-lg p-4">

<h5 class="fw-bold">Order Summary</h5>
<hr>

@php $total = 0; @endphp

@foreach($cart as $item)

@php
$subtotal = $item['price'] * $item['quantity'];
$total += $subtotal;
@endphp

<p>
{{ $item['name'] }} x {{ $item['quantity'] }}
<span class="float-end">₹ {{ $subtotal }}</span>
</p>

@endforeach

<hr>

<h4>Total
<span class="text-orange float-end">₹ {{ $total }}</span>
</h4>

<button class="btn btn-orange w-100 mt-4 btn-lg">
Confirm & Place Order
</button>

</div>
</div>

</div>

</form>
</div>

<script>
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
radio.addEventListener('change', function(){
document.getElementById('onlineSection').style.display =
this.value === 'online' ? 'block' : 'none';
});
});
</script>

@endsection
