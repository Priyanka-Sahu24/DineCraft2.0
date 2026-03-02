@extends('customer.layout')

@section('content')

<div class="container py-5 text-center">

    <div class="card shadow p-5">

        <h1 class="text-success mb-3">
            🎉 Reservation Confirmed!
        </h1>

        <p class="lead">
            Your table reservation request has been submitted successfully.
        </p>

        <p class="text-muted">
            Our team will review and confirm your booking shortly.
        </p>

        <div class="mt-4">
            <a href="{{ route('reservation') }}" class="btn btn-outline-warning me-3">
                Book Another Table
            </a>

            <a href="{{ route('home') }}" class="btn btn-warning">
                Back to Home
            </a>
        </div>

    </div>

</div>

@endsection