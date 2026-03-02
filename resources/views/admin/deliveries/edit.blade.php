@extends('admin.layouts.admin')

@section('title','Edit Delivery')

@section('content')

<div class="container mt-4">
    <h2 class="mb-4 text-orange">Edit Delivery</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.deliveries.update', $delivery->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow p-4">

            {{-- Order --}}
            <div class="mb-3">
                <label class="form-label">Order ID</label>
                <select name="order_id" class="form-control" required>
                    <option value="">Select Order</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}"
                            {{ $delivery->order_id == $order->id ? 'selected' : '' }}>
                            {{ $order->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Delivery Person --}}
            <div class="mb-3">
                <label class="form-label">Delivery Person</label>
                <select name="delivery_person_id" class="form-control" required>
                    <option value="">Select Delivery Person</option>
                    @foreach($deliveryPersons as $person)
                        <option value="{{ $person->id }}"
                            {{ $delivery->delivery_person_id == $person->id ? 'selected' : '' }}>
                            Employee ID: {{ $person->employee_id }} - {{ ucfirst($person->designation) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="assigned" {{ $delivery->status == 'assigned' ? 'selected' : '' }}>Assigned</option>
                    <option value="picked_up" {{ $delivery->status == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                    <option value="on_the_way" {{ $delivery->status == 'on_the_way' ? 'selected' : '' }}>On The Way</option>
                    <option value="delivered" {{ $delivery->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $delivery->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            {{-- Location --}}
            <div class="mb-3">
                <label class="form-label">Delivery Location</label>
                <input type="text"
                       name="location"
                       class="form-control"
                       value="{{ $delivery->location }}"
                       placeholder="Enter delivery location">
            </div>

            {{-- Estimated Time --}}
            <div class="mb-3">
                <label class="form-label">Estimated Time</label>
                <input type="datetime-local"
                       name="estimated_time"
                       class="form-control"
                       value="{{ $delivery->estimated_time ? \Carbon\Carbon::parse($delivery->estimated_time)->format('Y-m-d\TH:i') : '' }}">
            </div>

            <button type="submit" class="btn btn-orange">Update Delivery</button>
            <a href="{{ route('admin.deliveries.index') }}" class="btn btn-secondary">Cancel</a>

        </div>
    </form>
</div>

@endsection
