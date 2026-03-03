<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Dinecraft</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin/admin.css') }}" rel="stylesheet">
</head>
<body>

@include('admin.sidebar-style')

<div class="d-flex">

   <!-- ================= SIDEBAR ================= -->
<div class="sidebar p-3 flex-shrink-0">

    <div class="text-center mb-4">
        <div style="font-size:2.2rem; font-weight:900; letter-spacing:2px; color:#fff; text-shadow:0 2px 8px #fd7e14;">
              Dinecraft
        </div>
        <div style="font-size:0.95rem; color:#fff; opacity:0.7; margin-top:2px;">Admin Panel</div>
    </div>

    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
    </a>

    <!-- ================= STAFF MANAGEMENT ================= -->
    <p class="module-title mt-4">STAFF MANAGEMENT</p>

    <a href="{{ route('admin.staff.index') }}"
       class="nav-link {{ request()->routeIs('admin.staff*') ? 'active' : '' }}">
                Manage Staff
    </a>

    <a href="{{ route('admin.attendance.index') }}"
       class="nav-link {{ request()->routeIs('admin.attendance*') ? 'active' : '' }}">
                Staff Attendance
    </a>

     <a href="{{ route('admin.salaries.index') }}"
   class="nav-link {{ request()->routeIs('admin.salaries*') ? 'active' : '' }}">
        Manage Salaries
</a>

    <a href="{{ route('admin.leaves.index') }}"
       class="nav-link {{ request()->routeIs('admin.leaves*') ? 'active' : '' }}">
                Leave Requests
    </a>

    <!-- ================= RESTAURANT MANAGEMENT ================= -->
    <p class="module-title mt-4">RESTAURANT MANAGEMENT</p>

    <a href="{{ route('admin.users.index') }}"
       class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                Users
    </a>

    <a href="{{ route('admin.tables.index') }}"
       class="nav-link {{ request()->routeIs('admin.tables*') ? 'active' : '' }}">
                Manage Tables
    </a>

    <a href="{{ route('admin.categories.index') }}"
       class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                Categories
    </a>

    <a href="{{ route('admin.menu-items.index') }}"
       class="nav-link {{ request()->routeIs('admin.menu-items*') ? 'active' : '' }}">
                Menu Items
    </a>

    <!-- ================= OPERATIONS ================= -->
    <p class="module-title mt-4">OPERATIONS</p>

    <a href="{{ route('admin.orders.index') }}"
       class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                Orders
    </a>

     <a href="{{ route('admin.payments') }}"
         class="nav-link {{ request()->routeIs('admin.payments') ? 'active' : '' }}">
                     Payments
     </a>

    <a href="{{ route('admin.reservations.index') }}"
       class="nav-link {{ request()->routeIs('admin.reservations*') ? 'active' : '' }}">
                Reservations
    </a>

    <a href="{{ route('admin.inventory.index') }}"
       class="nav-link {{ request()->routeIs('admin.inventory*') ? 'active' : '' }}">
                Inventory
    </a>

    <a href="{{ route('admin.deliveries.index') }}"
       class="nav-link {{ request()->routeIs('admin.deliveries*') ? 'active' : '' }}">
                Delivery Tracker
    </a>

    <!-- ================= LOGOUT ================= -->
    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="logout-btn w-100">
                        Logout
        </button>
    </form>

</div>


    <!-- ================= MAIN CONTENT ================= -->
    <div class="flex-grow-1">

        <!-- Top Navbar -->
            <nav class="top-navbar d-flex justify-content-between align-items-center px-4 py-3" style="background-color: #fd7e14;">
            <div>
                 <strong style="color: #fff;">Admin Dashboard</strong>
            </div>

            <div>
                <span class="me-3">
                    Welcome, {{ auth()->user()->name }}
                </span>
                <span class="badge bg-danger">
                    <a href="{{ route('admin.profile') }}" class="text-white text-decoration-none">Admin</a>
                </span>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content p-4">
            @yield('content')
        </div>

    </div>

</div>
@yield('scripts')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>