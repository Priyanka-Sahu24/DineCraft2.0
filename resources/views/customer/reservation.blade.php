@extends('customer.layout')

@section('content')

<div class="container py-5">

<h2 class="fw-bold text-orange mb-4">
Reserve Your Table 🍽️
</h2>

<form method="POST" action="{{ route('reservation.store') }}">
@csrf

<div class="card shadow p-4">

<div class="row">

<div class="col-md-6 mb-3">
<label>Date</label>
<input type="date" name="reservation_date"
       class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Time</label>
<input type="time" name="reservation_time"
       class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>No. of Guests</label>
<input type="number" name="guest_count"
       class="form-control"
       min="1" max="20" required>
</div>

<div class="col-md-6 mb-3">
<label>Special Request</label>
<textarea name="special_request"
          class="form-control"></textarea>
</div>

</div>

<button class="btn btn-orange w-100 mt-3">
Book Table
</button>

</div>

</form>

</div>

@endsection