@extends('staff.layout')

@section('content')



<div class="container py-3">
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card p-4 shadow border-0" style="background: #fff7ef;">
                <h6 class="fw-bold text-uppercase mb-2" style="color:#fd7e14;">Today's Schedule</h6>
                <ul class="mb-0">
                    <li>Shift: <strong>{{ auth()->user()->staff->shift ?? '-' }}</strong></li>
                    <li>Role: <strong>{{ ucfirst(auth()->user()->getRoleNames()->first() ?? '-') }}</strong></li>
                    <li>Assigned Tables/Deliveries: ...</li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow border-0" style="background: #f0f9ff;">
                <h6 class="fw-bold text-uppercase mb-2" style="color:#0d6efd;">Quick Stats</h6>
                <ul class="mb-0">
                    <li>Orders: <span class="badge bg-primary">...</span></li>
                    <li>Reservations: <span class="badge bg-info">...</span></li>
                    <li>Attendance: <span class="badge bg-success">...</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow border-0" style="background: #fff3cd;">
                <h6 class="fw-bold text-uppercase mb-2" style="color:#fd7e14;">Notifications</h6>
                <ul class="mb-0">
                    <li>No new notifications.</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card p-4 shadow border-0" style="background: #f8f9fa;">
                <h6 class="fw-bold text-uppercase mb-2" style="color:#fd7e14;">Pending Tasks</h6>
                <ul class="mb-0">
                    <li>Pending Orders: ...</li>
                    <li>Pending Deliveries: ...</li>
                    <li>Pending Reservations: ...</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 shadow border-0" style="background: #eafbea;">
                <h6 class="fw-bold text-uppercase mb-2" style="color:#198754;">Attendance</h6>
                <div>Today: ... <button class="btn btn-sm btn-success ms-2">Clock In</button></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card p-4 shadow border-0" style="background: #f8f9fa;">
                <h6 class="fw-bold text-uppercase mb-2" style="color:#fd7e14;">Recent Activity</h6>
                <ul class="mb-0">
                    <li>Order #123 completed</li>
                    <li>Reservation #45 served</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 shadow border-0" style="background: #f8f9fa;">
                <h6 class="fw-bold text-uppercase mb-2" style="color:#fd7e14;">Leave/Salary Info</h6>
                <ul class="mb-0">
                    <li>Leaves Remaining: ...</li>
                    <li>Last Salary: ...</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-12">
            <div class="card p-4 shadow border-0" style="background: #f0f9ff;">
                <h6 class="fw-bold text-uppercase mb-2" style="color:#0d6efd;">Useful Shortcuts</h6>
                <a href="#" class="btn btn-outline-primary btn-sm me-2">Order Management</a>
                <a href="#" class="btn btn-outline-primary btn-sm me-2">Reservations</a>
                <a href="#" class="btn btn-outline-primary btn-sm me-2">Attendance</a>
                <a href="#" class="btn btn-outline-primary btn-sm">Leave Requests</a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Existing role-based widgets (chef, waiter, cashier, delivery) --}}
        @if(auth()->user()->hasRole('chef'))
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h5>Pending Orders</h5>
                    <h3>{{ $pendingOrders ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h5>Preparing Orders</h5>
                    <h3>{{ $preparingOrders ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card p-4 shadow">
                    <h5>Chef Orders Status Chart</h5>
                    <canvas id="chefChart"></canvas>
                </div>
            </div>
        @endif
        @if(auth()->user()->hasRole('waiter'))
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h5>My Orders</h5>
                    <h3>{{ $myOrders ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h5>Active Orders</h5>
                    <h3>{{ $activeOrders ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card p-4 shadow">
                    <h5>Waiter Orders Chart</h5>
                    <canvas id="waiterChart"></canvas>
                </div>
            </div>
        @endif
        @if(auth()->user()->hasRole('cashier'))
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h5>Completed Orders</h5>
                    <h3>{{ $completedOrders ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h5>Today's Orders</h5>
                    <h3>{{ $todayOrders ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card p-4 shadow">
                    <h5>Cashier Performance (Line Chart)</h5>
                    <canvas id="cashierChart"></canvas>
                </div>
            </div>
        @endif
        @if(auth()->user()->hasRole('delivery'))
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h5>Delivery Orders</h5>
                    <h3>{{ $deliveryOrders ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h5>Delivered Orders</h5>
                    <h3>{{ $deliveredOrders ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card p-4 shadow">
                    <h5>Delivery Chart (Pie)</h5>
                    <canvas id="deliveryChart"></canvas>
                </div>
            </div>
        @endif
    </div>
</div>


{{-- ================= CHART JS CDN ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function() {

    {{-- CHEF BAR CHART --}}
    @if(auth()->user()->hasRole('chef'))
    new Chart(document.getElementById('chefChart'), {
        type: 'bar',
        data: {
            labels: ['Pending', 'Preparing'],
            datasets: [{
                label: 'Orders',
                data: [
                    {{ $pendingOrders ?? 0 }},
                    {{ $preparingOrders ?? 0 }}
                ],
                backgroundColor: ['#f39c12', '#3498db']
            }]
        }
    });
    @endif


    {{-- WAITER BAR CHART --}}
    @if(auth()->user()->hasRole('waiter'))
    new Chart(document.getElementById('waiterChart'), {
        type: 'bar',
        data: {
            labels: ['My Orders', 'Active Orders'],
            datasets: [{
                label: 'Orders',
                data: [
                    {{ $myOrders ?? 0 }},
                    {{ $activeOrders ?? 0 }}
                ],
                backgroundColor: ['#2ecc71', '#e74c3c']
            }]
        }
    });
    @endif


    {{-- CASHIER LINE CHART --}}
    @if(auth()->user()->hasRole('cashier'))
    new Chart(document.getElementById('cashierChart'), {
        type: 'line',
        data: {
            labels: ['Completed', 'Today'],
            datasets: [{
                label: 'Orders',
                data: [
                    {{ $completedOrders ?? 0 }},
                    {{ $todayOrders ?? 0 }}
                ],
                borderColor: '#8e44ad',
                fill: false,
                tension: 0.3
            }]
        }
    });
    @endif


    {{-- DELIVERY PIE CHART --}}
    @if(auth()->user()->hasRole('delivery'))
    new Chart(document.getElementById('deliveryChart'), {
        type: 'pie',
        data: {
            labels: ['Delivery Orders', 'Delivered Orders'],
            datasets: [{
                data: [
                    {{ $deliveryOrders ?? 0 }},
                    {{ $deliveredOrders ?? 0 }}
                ],
                backgroundColor: ['#1abc9c', '#e67e22']
            }]
        }
    });
    @endif

});

</script>

@endsection