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
			<div class="card shadow border-0 rounded-4 overflow-hidden mb-4">
				<div class="card-body p-0">
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
								<tr>
									<td>ORD-12345</td>
									<td>Dine-in</td>
									<td><span class="badge bg-success px-3 py-2">Completed</span></td>
									<td>₹ 1,250.00</td>
									<td>25 Feb 2026</td>
									<td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
								</tr>
								<tr>
									<td>ORD-12344</td>
									<td>Takeaway</td>
									<td><span class="badge bg-warning text-dark px-3 py-2">Pending</span></td>
									<td>₹ 890.00</td>
									<td>24 Feb 2026</td>
									<td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<a href="{{ route('my.orders') }}" class="btn btn-link text-orange fw-semibold">View All Orders</a>
		</div>
	</section>

	<!-- Reservations Section -->
	<section class="py-5" style="background: #fff3e8;">
		<div class="container">
			<h2 class="fw-bold text-orange mb-4">Upcoming Reservations</h2>
			<div class="card shadow border-0 rounded-4 overflow-hidden mb-4">
				<div class="card-body p-0">
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
								<tr>
									<td>28 Feb 2026</td>
									<td>7:30 PM</td>
									<td>4</td>
									<td><span class="badge bg-success px-3 py-2">Confirmed</span></td>
									<td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
								</tr>
								<tr>
									<td>01 Mar 2026</td>
									<td>8:00 PM</td>
									<td>2</td>
									<td><span class="badge bg-warning text-dark px-3 py-2">Pending</span></td>
									<td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<a href="/reservations" class="btn btn-link text-orange fw-semibold">View All Reservations</a>
		</div>
	</section>

	<!-- Cart Section -->
	<section class="py-5" style="background: #fffefb;">
		<div class="container">
			<h2 class="fw-bold text-orange mb-4">My Cart</h2>
			<div class="card shadow border-0 rounded-4 overflow-hidden mb-4">
				<div class="card-body">
					<div class="d-flex align-items-center mb-3">
						<img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" width="48" class="me-3">
						<div>
							<div class="fw-semibold">Margherita Pizza x2</div>
							<div class="text-muted small">₹ 500.00 each</div>
						</div>
						<span class="ms-auto fw-bold">₹ 1,000.00</span>
					</div>
					<div class="d-flex align-items-center mb-3">
						<img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png" width="48" class="me-3">
						<div>
							<div class="fw-semibold">Paneer Tikka x1</div>
							<div class="text-muted small">₹ 350.00 each</div>
						</div>
						<span class="ms-auto fw-bold">₹ 350.00</span>
					</div>
					<div class="text-end">
						<a href="/cart" class="btn btn-orange">Go to Cart</a>
					</div>
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