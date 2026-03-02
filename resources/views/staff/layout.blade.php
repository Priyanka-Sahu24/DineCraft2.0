<!DOCTYPE html>
<html>
<head>
    <title>Staff Panel - Dinecraft</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
</head>
<body>

<!-- ================= TOP NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#ff6a00;">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">Dinecraft Staff Panel</span>
        <button class="btn btn-light ms-auto" data-bs-toggle="modal" data-bs-target="#profileModal">
            <span class="me-2">👤</span> Profile
        </button>
    </div>
</nav>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar">
    <h3 class="text-center text-white mb-4">Dinecraft</h3>
    <!-- Modules Dropdown -->
    <div class="dropdown mb-3">
        <button class="btn btn-orange w-100 dropdown-toggle" type="button" id="modulesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Modules
        </button>
        <ul class="dropdown-menu w-100" aria-labelledby="modulesDropdown">
            <li><a class="dropdown-item" href="{{ route('staff.dashboard') }}">Dashboard</a></li>
            <li><a class="dropdown-item" href="{{ route('staff.orders') }}">My Orders</a></li>
            <li><a class="dropdown-item" href="{{ route('staff.orders.active') }}">Active Orders</a></li>
            <li><a class="dropdown-item" href="{{ route('staff.reservations') }}">Table Reservations</a></li>
            <li><a class="dropdown-item" href="{{ route('staff.attendance') }}">Attendance</a></li>
            <li><a class="dropdown-item" href="{{ route('staff.leaves') }}">Leave Requests</a></li>
            <li><a class="dropdown-item" href="{{ route('staff.salaries.index') }}">My Salaries</a></li>
            <li><a class="dropdown-item" href="{{ route('staff.profile') }}">My Profile</a></li>
        </ul>
    </div>
    <!-- Dashboard -->
    <a href="{{ route('staff.dashboard') }}" class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
    <!-- ORDER MANAGEMENT -->
    <p class="module-title">ORDER MANAGEMENT</p>
    <a href="{{ route('staff.orders') }}" class="nav-link {{ request()->routeIs('staff.orders') ? 'active' : '' }}">📋 My Orders</a>
    <a href="{{ route('staff.orders.active') }}" class="nav-link {{ request()->routeIs('staff.orders.active') ? 'active' : '' }}">🔥 Active Orders</a>
    <!-- RESERVATIONS -->
    <p class="module-title">RESERVATIONS</p>
    <a href="{{ route('staff.reservations') }}" class="nav-link {{ request()->routeIs('staff.reservations') ? 'active' : '' }}">🪑 Table Reservations</a>
    <!-- ATTENDANCE -->
    <p class="module-title">ATTENDANCE</p>
    <a href="{{ route('staff.attendance') }}" class="nav-link {{ request()->routeIs('staff.attendance') ? 'active' : '' }}">🕒 Mark Attendance</a>
    <!-- SALARY -->
    <a href="{{ route('staff.salaries.index') }}" class="nav-link {{ request()->routeIs('staff.salaries*') ? 'active' : '' }}">💵 My Salaries</a>
    <!-- LEAVES -->
    <p class="module-title">LEAVE MANAGEMENT</p>
    <a href="{{ route('staff.leaves') }}" class="nav-link {{ request()->routeIs('staff.leaves*') ? 'active' : '' }}">📝 Apply Leave</a>
    <!-- ACCOUNT -->
    <p class="module-title">ACCOUNT</p>
    <a href="{{ route('staff.profile') }}" class="nav-link {{ request()->routeIs('staff.profile*') ? 'active' : '' }}">👤 My Profile</a>
    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit" class="logout-btn">🚪 Logout</button>
    </form>
</div>
<!-- ================= CONTENT ================= -->
<div class="content" style="background:#f8f9fa; min-height:100vh;">
        @yield('content')
</div>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">My Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Name:</strong> {{ auth()->user()->name }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ auth()->user()->email }}</li>
                    <li class="list-group-item"><strong>Phone:</strong> {{ auth()->user()->phone ?? '-' }}</li>
                    <li class="list-group-item"><strong>Role:</strong> {{ ucfirst(auth()->user()->getRoleNames()->first() ?? '-') }}</li>
                    <li class="list-group-item"><strong>Shift:</strong> {{ auth()->user()->staff->shift ?? '-' }}</li>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="{{ route('staff.profile') }}" class="btn btn-primary">View Full Profile</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>