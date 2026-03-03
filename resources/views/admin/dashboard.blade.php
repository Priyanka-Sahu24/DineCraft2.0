@extends('admin.layouts.admin')

@section('content')


<div class="container-fluid py-4">
    <h3 class="mb-4 fw-bold" style="color:#ff6a00; text-shadow:0 2px 8px #fff, 0 1px 6px rgba(0,0,0,0.10); letter-spacing:1px;">Admin Dashboard <span style="font-size:1.2rem;">📊</span></h3>

    <!-- Quick Links -->
    <div class="row mb-4 g-3">
        <div class="col-auto">
            <a href="{{ route('admin.staff.index') }}" class="btn btn-orange shadow-sm"><i class="bi bi-people me-2"></i>Staff</a>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-dark shadow-sm"><i class="bi bi-calendar-check me-2"></i>Attendance</a>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.leaves.index') }}" class="btn btn-outline-primary shadow-sm"><i class="bi bi-journal-text me-2"></i>Leaves</a>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary shadow-sm"><i class="bi bi-bag-check me-2"></i>Orders</a>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-success shadow-sm"><i class="bi bi-calendar-event me-2"></i>Reservations</a>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-warning shadow-sm"><i class="bi bi-box-seam me-2"></i>Inventory</a>
        </div>
    </div>

    <!-- TOP CARDS -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card p-4 shadow border-0" style="border-top:4px solid #ff6a00; background:linear-gradient(135deg,#fff7f0 80%,#fff1e6 100%);">
                <h6 style="color:#ff6a00; font-weight:700;">Total Staff</h6>
                <h3 style="color:#222;">{{ $totalStaff }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-4 shadow border-0" style="border-top:4px solid #ff6a00; background:linear-gradient(135deg,#fff7f0 80%,#fff1e6 100%);">
                <h6 style="color:#ff6a00; font-weight:700;">Total Tables</h6>
                <h3 style="color:#222;">{{ $totalTables }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-4 shadow border-0" style="border-top:4px solid #ff6a00; background:linear-gradient(135deg,#fff7f0 80%,#fff1e6 100%);">
                <h6 style="color:#ff6a00; font-weight:700;">Total Orders</h6>
                <h3 style="color:#222;">{{ $totalOrders }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-4 shadow border-0" style="border-top:4px solid #ff6a00; background:linear-gradient(135deg,#fff7f0 80%,#fff1e6 100%);">
                <h6 style="color:#ff6a00; font-weight:700;">Total Revenue</h6>
                <h3 style="color:#222;">₹ {{ number_format($totalRevenue,2) }}</h3>
            </div>
        </div>
    </div>

    <!-- Pending Actions & Notifications -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow border-0 p-4 h-100">
                <h5 class="fw-bold mb-3 text-orange"><i class="bi bi-exclamation-circle me-2"></i>Pending Actions</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pending Leave Requests
                        <span class="badge bg-warning text-dark">Check Leaves</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pending Orders
                        <span class="badge bg-warning text-dark">Check Orders</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Low Inventory Alerts
                        <span class="badge bg-danger">Check Inventory</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow border-0 p-4 h-100">
                <h5 class="fw-bold mb-3 text-orange"><i class="bi bi-bell me-2"></i>Notifications</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">No new notifications.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card shadow border-0 p-4">
                <h5 class="fw-bold mb-3 text-orange"><i class="bi bi-clock-history me-2"></i>Recent Activity</h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td><span class="badge bg-primary">Order</span></td>
                                    <td>Order #{{ $order->order_number }} placed by {{ $order->user->name ?? 'Unknown' }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                            @foreach($recentReservations as $reservation)
                                <tr>
                                    <td><span class="badge bg-success">Reservation</span></td>
                                    <td>Table reserved by {{ $reservation->user->name ?? 'Unknown' }}</td>
                                    <td>{{ $reservation->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                            @foreach($recentLeaves as $leave)
                                <tr>
                                    <td><span class="badge bg-warning text-dark">Leave</span></td>
                                    <td>Leave request submitted by {{ $leave->staff->user->name ?? 'Staff #'.$leave->staff_id }}</td>
                                    <td>{{ $leave->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="row mt-4 g-4">
        <div class="col-lg-6">
            <div class="card p-4 shadow border-0" style="border-left:4px solid #ff6a00;">
                <h5 style="color:#ff6a00; font-weight:700;">Monthly Orders (Line)</h5>
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card p-4 shadow border-0" style="border-left:4px solid #ff6a00;">
                <h5 style="color:#ff6a00; font-weight:700;">Monthly Revenue (Bar)</h5>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card p-4 shadow border-0" style="border-left:4px solid #ff6a00;">
                <h5 style="color:#ff6a00; font-weight:700;">Order Type (Pie)</h5>
                <canvas id="orderTypeChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card p-4 shadow border-0" style="border-left:4px solid #ff6a00;">
                <h5 style="color:#ff6a00; font-weight:700;">Order Status (Doughnut)</h5>
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// LINE CHART
new Chart(document.getElementById('ordersChart'), {
    type: 'line',
    data: {
        labels: @json($ordersChartLabels),
        datasets: [{
            label: 'Orders',
            data: @json($ordersChartData),
            borderWidth: 3,
            tension: 0.4,
            fill: true
        }]
    }
});

// BAR CHART
new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: @json($revenueChartLabels),
        datasets: [{
            label: 'Revenue',
            data: @json($revenueChartData),
            borderRadius: 8
        }]
    }
});

// PIE CHART
new Chart(document.getElementById('orderTypeChart'), {
    type: 'pie',
    data: {
        labels: @json($orderTypeLabels),
        datasets: [{
            data: @json($orderTypeCounts)
        }]
    }
});

// DOUGHNUT CHART
new Chart(document.getElementById('orderStatusChart'), {
    type: 'doughnut',
    data: {
        labels: @json($orderStatusLabels),
        datasets: [{
            data: @json($orderStatusCounts)
        }]
    }
});

</script>

@endsection