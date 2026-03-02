<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinecraft Restaurant</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Customer Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/customer/style.css') }}">
</head>
<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
<div class="container">

<a class="navbar-brand fw-bold text-orange fs-4" href="/">
DineCraft 🍽️
</a>

<button class="navbar-toggler" type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarNav">


<ul class="navbar-nav ms-auto align-items-center">
    <!-- Modules Dropdown -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="modulesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Modules
        </a>
        <ul class="dropdown-menu" aria-labelledby="modulesDropdown">
            <li><a class="dropdown-item" href="/">Home</a></li>
            <li><a class="dropdown-item" href="/menu">Menu</a></li>
            <li><a class="dropdown-item" href="/cart">Cart</a></li>
            <li><a class="dropdown-item" href="/reservations">Reservations</a></li>
            @auth
                <li><a class="dropdown-item" href="{{ route('my.orders') }}">My Orders</a></li>
            @endauth
        </ul>
    </li>

    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
    <li class="nav-item"><a class="nav-link" href="/menu">Menu</a></li>
    <li class="nav-item"><a class="nav-link" href="/cart">Cart 🛒</a></li>
    <li class="nav-item"><a class="nav-link" href="/reservations">Reservations 🍽️</a></li>

    @auth
    <li class="nav-item"><a class="nav-link" href="{{ route('my.orders') }}">My Orders 📦</a></li>
    <li class="nav-item ms-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-danger">Logout</button>
        </form>
    </li>
    @else
    <li class="nav-item ms-2">
        <a class="btn btn-orange" href="/login">Login</a>
    </li>
    @endauth

</ul>
</div>
</div>
</nav>

<!-- ================= PAGE CONTENT ================= -->
<main>
    @yield('content')
</main>

<!-- ================= FOOTER ================= -->
<footer class="mt-5">
    <div class="container text-center">

        <h5 class="mb-3">Dinecraft Restaurant</h5>
        <p>Experience premium dining with delicious food and warm hospitality.</p>

        <div class="mt-3">
            <p class="mb-1">📍 123 Main Street, Your City</p>
            <p class="mb-1">📞 +91 98765 43210</p>
            <p class="mb-0">✉ info@dinecraft.com</p>
        </div>

        <hr class="bg-light mt-4">

        <p class="mb-0">
            © {{ date('Y') }} Dinecraft Restaurant. All rights reserved.
        </p>

    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>