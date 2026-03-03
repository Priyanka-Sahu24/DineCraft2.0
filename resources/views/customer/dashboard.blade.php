@extends('customer.layout')

@section('content')

<div class="container-fluid px-0" style="background: #fffefb;">
	<!-- Welcome Section -->
	<section class="py-5 text-center" style="background: linear-gradient(90deg, #fff3e8 60%, #fffefb 100%);">
		<img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=fd7e14&color=fff&size=120" class="rounded-circle mb-3 shadow" width="100" height="100" alt="Avatar">
		<h1 class="fw-bold text-orange mb-2" style="font-size:2.5rem;">Welcome, {{ auth()->user()->name }} 👋</h1>
		<p class="lead text-muted mb-4">Enjoy premium dining and fast ordering!</p>
		<div class="d-flex flex-wrap justify-content-center gap-3 mb-2">
			<a href="/" class="btn btn-orange btn-lg px-4"><i class="bi bi-list-ul me-2"></i>Browse Menu</a>
			<a href="{{ route('my.orders') }}" class="btn btn-outline-dark btn-lg px-4"><i class="bi bi-bag-check me-2"></i>My Orders</a>
			<a href="/cart" class="btn btn-outline-secondary btn-lg px-4"><i class="bi bi-cart3 me-2"></i>My Cart</a>
			<a href="/reservations" class="btn btn-outline-primary btn-lg px-4"><i class="bi bi-calendar-check me-2"></i>Reservations</a>
		</div>
	</section>

	<!-- Orders Section -->
	<section class="py-5" style="background: #fffefb;">
		<div class="container">
			<h2 class="fw-bold text-orange mb-4">My Recent Orders</h2>
			@php
				$recentOrders = \App\Models\Order::where('user_id', auth()->id())->latest()->take(3)->get();
			@endphp
			<div class="card shadow border-0 rounded-4 overflow-hidden mb-4">
				<div class="card-body p-0">
					@if($recentOrders->count() > 0)
					<div class="table-responsive">
						<table class="table align-middle mb-0">
							<thead class="table-light">
								<tr>
									<th>Order ID</th>
									<th>Type</th>
									<th>Status</th>
									<th>Total</th>
									<th>Date</th>
									<th width="120">Action</th>
								</tr>
							</thead>
							<tbody>
							@foreach($recentOrders as $order)
								<tr>
									<td class="fw-semibold">{{ $order->order_number }}</td>
									<td>{{ ucfirst($order->order_type) }}</td>
									<td>
										@php $status = strtolower($order->order_status); @endphp
										@if($status == 'pending')
											<span class="badge bg-warning text-dark px-3 py-2">Pending</span>
										@elseif($status == 'preparing')
											<span class="badge bg-info px-3 py-2">Preparing</span>
										@elseif($status == 'completed')
											<span class="badge bg-success px-3 py-2">Completed</span>
										@elseif($status == 'cancelled')
											<span class="badge bg-danger px-3 py-2">Cancelled</span>
										@else
											<span class="badge bg-secondary px-3 py-2">{{ ucfirst($status) }}</span>
										@endif
									</td>
									<td>₹ {{ number_format($order->total,2) }}</td>
									<td>{{ $order->created_at->format('d M Y') }}</td>
									<td><a href="{{ route('order.track', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
					@else
						<div class="p-4 text-center text-muted">No recent orders yet.</div>
					@endif
				</div>
			</div>
			<a href="{{ route('my.orders') }}" class="btn btn-link text-orange fw-semibold">View All Orders</a>
		</div>
	</section>

	<!-- Reservations Section -->
	<section class="py-5" style="background: #fff3e8;">
		<div class="container">
			<h2 class="fw-bold text-orange mb-4">Upcoming Reservations</h2>
			@php
				$upcomingReservations = \App\Models\Reservation::where('user_id', auth()->id())
					->whereDate('reservation_date', '>=', now()->toDateString())
					->orderBy('reservation_date')
					->take(3)
					->get();
			@endphp
			<div class="card shadow border-0 rounded-4 overflow-hidden mb-4">
				<div class="card-body p-0">
					@if($upcomingReservations->count() > 0)
					<div class="table-responsive">
						<table class="table align-middle mb-0">
							<thead class="table-light">
								<tr>
									<th>Date</th>
									<th>Time</th>
									<th>Guests</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@foreach($upcomingReservations as $reservation)
								<tr>
									<td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}</td>
									<td>{{ $reservation->reservation_time }}</td>
									<td>{{ $reservation->guest_count }}</td>
									<td>
										@if($reservation->status == 'confirmed')
											<span class="badge bg-success px-3 py-2">Confirmed</span>
										@elseif($reservation->status == 'pending')
											<span class="badge bg-warning text-dark px-3 py-2">Pending</span>
										@elseif($reservation->status == 'cancelled')
											<span class="badge bg-danger px-3 py-2">Cancelled</span>
										@else
											<span class="badge bg-secondary px-3 py-2">{{ ucfirst($reservation->status) }}</span>
										@endif
									</td>
									<td><a href="/reservations" class="btn btn-sm btn-outline-primary">View</a></td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
					@else
						<div class="p-4 text-center text-muted">No upcoming reservations.</div>
					@endif
				</div>
			</div>
			<a href="/reservations" class="btn btn-link text-orange fw-semibold">View All Reservations</a>
		</div>
	</section>

	<!-- Cart Section -->
	<section class="py-5" style="background: #fffefb;">
		<div class="container">
			<h2 class="fw-bold text-orange mb-4">My Cart</h2>
			@php
				$cart = session('cart', []);
			@endphp
			<div class="card shadow border-0 rounded-4 overflow-hidden mb-4">
				<div class="card-body">
					@if(count($cart) > 0)
						@php $grandTotal = 0; @endphp
						@foreach($cart as $item)
							@php
								$total = $item['price'] * $item['quantity'];
								$grandTotal += $total;
							@endphp
							<div class="d-flex align-items-center mb-3">
								<img src="{{ isset($item['image']) ? asset('storage/'.$item['image']) : 'https://cdn-icons-png.flaticon.com/512/1170/1170678.png' }}" width="48" class="me-3">
								<div>
									<div class="fw-semibold">{{ $item['name'] }} x{{ $item['quantity'] }}</div>
									<div class="text-muted small">₹ {{ number_format($item['price'],2) }} each</div>
								</div>
								<span class="ms-auto fw-bold">₹ {{ number_format($total,2) }}</span>
							</div>
						@endforeach
						<div class="text-end mt-3">
							<span class="fw-bold">Total: ₹ {{ number_format($grandTotal,2) }}</span>
							<a href="/cart" class="btn btn-orange ms-3">Go to Cart</a>
						</div>
					@else
						<div class="p-4 text-center text-muted">Your cart is empty.</div>
					@endif
				</div>
			</div>
		</div>
	</section>

	<!-- Profile Section -->
	<section class="py-5" style="background: #fff3e8;">
		<div class="container">
			<h2 class="fw-bold text-orange mb-4">My Profile</h2>
			<div class="card shadow border-0 rounded-4 overflow-hidden mb-4 p-4" style="max-width: 500px; margin:auto;">
				<div class="mb-2"><i class="bi bi-person-circle me-2"></i> <span class="fw-semibold">{{ auth()->user()->name }}</span></div>
				<div class="mb-2"><i class="bi bi-envelope me-2"></i> {{ auth()->user()->email }}</div>
				<div class="mb-2"><i class="bi bi-telephone me-2"></i> {{ auth()->user()->phone ?? '-' }}</div>
				<div class="mb-2"><i class="bi bi-geo-alt me-2"></i> {{ auth()->user()->address ?? '-' }}</div>
				<a href="#" class="btn btn-link text-orange fw-semibold mt-2">Edit Profile</a>
			</div>
		</div>
	</section>
</div>

@endsection