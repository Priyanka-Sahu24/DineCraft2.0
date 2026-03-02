@extends('customer.layout')

@section('content')

<!-- ================= HERO SECTION ================= -->
<section class="hero-premium">
    <div class="container text-center">

        <h1 class="hero-logo">
            DINE<span>CRAFT</span>
        </h1>

        <p class="hero-caption">
            Smart Restaurant Management System
        </p>

        <p class="hero-sub">
            Manage Orders • Reservations • Menu • Customers
            with one intelligent and powerful platform.
        </p>

        <div class="hero-buttons mt-5">
            <a href="{{ route('menu') }}" class="btn btn-orange btn-lg me-3">
                Explore Menu
            </a>

            <a href="#about" class="btn btn-outline-dark btn-lg">
                Learn More
            </a>
        </div>

    </div>
</section>


<!-- ================= ABOUT SECTION ================= -->
<section id="about" class="about-section">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-6">
                <h2 class="section-title mb-4">About DineCraft</h2>
                <p>
                    DineCraft is a modern Smart Restaurant Management System
                    designed to simplify restaurant operations.
                    From online ordering to table reservations,
                    everything is managed seamlessly.
                </p>

                <p>
                    Built with powerful technologies,
                    DineCraft helps restaurants increase efficiency,
                    enhance customer experience and boost growth.
                </p>
            </div>

            <div class="col-md-6">
                <div class="about-box">
                    <h5>✔ Easy Order Management</h5>
                    <h5>✔ Smart Table Reservations</h5>
                    <h5>✔ Menu & Category Control</h5>
                    <h5>✔ Real-time Analytics</h5>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ================= SERVICES ================= -->
<section class="services-section bg-light">
    <div class="container text-center">

        <h2 class="section-title mb-5">Our Services</h2>

        <div class="row">

            <div class="col-md-4 mb-4">
                <div class="service-box">
                    <h4>🚚 Fast Delivery</h4>
                    <p>Quick and reliable delivery service.</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="service-box">
                    <h4>🍽️ Dine-In</h4>
                    <p>Premium dining experience at your table.</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="service-box">
                    <h4>📅 Reservations</h4>
                    <p>Book tables easily in advance.</p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ================= CATEGORIES ================= -->
<section class="categories-section">
    <div class="container text-center">

        <h2 class="section-title mb-5">Food Categories</h2>

        <div class="row">

            @foreach($categories as $category)
            <div class="col-md-3 mb-4">
                <div class="category-box">

                    <div class="category-icon">🍽️</div>

                    <h5 class="fw-bold mt-3">
                        {{ $category->name }}
                    </h5>

                    <a href="/menu?category={{ $category->id }}"
                       class="btn btn-sm btn-orange mt-3">
                        View Items
                    </a>

                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>


<!-- ================= POPULAR DISHES ================= -->
<section class="popular-section bg-light">
    <div class="container text-center">

        <h2 class="section-title mb-5">Popular Dishes</h2>

        <div class="row">

            @foreach($popularItems as $item)
            <div class="col-md-4 mb-4">
                <div class="card food-card">

                    <img src="{{ asset('storage/'.$item->image) }}"
                         class="card-img-top">

                    <div class="card-body">
                        <h5 class="fw-bold">{{ $item->name }}</h5>
                        <p class="text-muted">₹ {{ $item->price }}</p>

                        <form method="POST"
                              action="{{ route('cart.add',$item->id) }}">
                            @csrf
                            <button class="btn btn-orange w-100">
                                Add to Cart
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>


<!-- ================= CTA ================= -->
<section class="cta-section text-center text-white">
    <div class="container">
        <h3>Hungry? Let’s Order Something Delicious!</h3>

        <a href="{{ route('menu') }}"
           class="btn btn-light mt-3">
            Browse Full Menu
        </a>
    </div>
</section>

@endsection