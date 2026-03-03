@extends('customer.layout')

@section('content')

<div class="container py-5">

<h2 class="fw-bold text-orange mb-4">
Our Menu 🍽️
</h2>

<div class="row">

@foreach($menuItems as $item)

<div class="col-md-4 mb-4">
<div class="card shadow food-card">

<img src="{{ asset('storage/'.$item->image) }}"
class="card-img-top"
style="height:220px; object-fit:cover;">

<div class="card-body">

<h5 class="fw-bold">{{ $item->name }}</h5>

<p class="text-muted">
₹ {{ $item->price }}
</p>


@php
	$canAddToCart = auth()->check() && auth()->user()->hasRole('customer');
@endphp

@if($canAddToCart)
	<form method="POST" action="{{ route('cart.add',$item->id) }}">
		@csrf
		<button class="btn btn-orange w-100">Add to Cart</button>
	</form>
@else
	<button class="btn btn-orange w-100" onclick="showLoginModal()">Add to Cart</button>
@endif

</div>
</div>
</div>

@endforeach

</div>

</div>

@endsection