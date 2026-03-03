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

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/login">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-orange w-100">Login</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="/register">New user? Register here</a>
                </div>
            </div>
        </div>
    </div>
</div>

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


</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showLoginModal() {
    setTimeout(function() {
        var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    }, 300);
}

document.addEventListener('DOMContentLoaded', function() {
    var isGuest = {{ Auth::check() ? 'false' : 'true' }};
    if (isGuest) {
        var selectors = [
            'a[href="/cart"]',
            'a[href="/reservations"]',
            'a[href="/orders"]',
            'a[href*="my.orders"]',
            'a[href="{{ route('cart.index', [], false) }}"]',
            'a[href="{{ route('reservation', [], false) }}"]',
            'a[href="{{ route('my.orders', [], false) }}"]'
        ];
        var links = document.querySelectorAll(selectors.join(','));
        links.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showLoginModal();
            });
        });
    }
});
</script>
</body>
</html>