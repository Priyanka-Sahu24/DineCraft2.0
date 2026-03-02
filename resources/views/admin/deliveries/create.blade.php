@extends('admin.layouts.admin')

@section('title','Assign Delivery')

@section('content')

<div class="container mt-4">
    <h2 class="mb-4 text-orange">Assign Delivery</h2>

    <form action="{{ route('admin.deliveries.store') }}" method="POST">
        @csrf

        {{-- Order ID --}}
        <div class="mb-3">
            <label>Order ID</label>
            <select name="order_id" class="form-control" required>
                <option value="">Select Order ID</option>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}">
                        #{{ $order->order_number }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Delivery Person --}}
        <div class="mb-3">
            <label>Delivery Person</label>
            <select name="delivery_person_id" class="form-control" required>
                <option value="">Select Delivery Person</option>
                @foreach($deliveryPersons as $person)
                    <option value="{{ $person->id }}">
                        Employee ID: {{ $person->employee_id }} - {{ ucfirst($person->designation) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="assigned">Assigned</option>
                <option value="picked_up">Picked Up</option>
                <option value="on_the_way">On The Way</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        {{-- Estimated Time --}}
        <div class="mb-3">
            <label>Estimated Time</label>
            <input type="datetime-local" name="estimated_time" class="form-control">
        </div>

        {{-- Location --}}
        <div class="mb-3">
            <label>Delivery Location</label>
            <input type="text" name="location" class="form-control" placeholder="Enter delivery location">
        </div>

        <button type="submit" class="btn btn-orange">Assign Delivery</button>
    </form>
</div>

@endsection
