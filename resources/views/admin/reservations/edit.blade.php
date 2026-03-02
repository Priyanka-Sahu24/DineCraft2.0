@extends('admin.layouts.admin')
@section('title','Edit Reservation')
@section('content')

<div class="container mt-4">
    <h2>Edit Reservation</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- User -->
        <div class="mb-3">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"
                        {{ $reservation->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Table -->
        <div class="mb-3">
            <label>Table</label>
            <select name="table_id" class="form-control" required>
                @foreach($tables as $table)
                    <option value="{{ $table->id }}"
                        {{ $reservation->table_id == $table->id ? 'selected' : '' }}>
                        Table {{ $table->table_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Date -->
        <div class="mb-3">
            <label>Reservation Date</label>
            <input type="date"
                   name="reservation_date"
                   value="{{ $reservation->reservation_date }}"
                   class="form-control"
                   required>
        </div>

        <!-- Time -->
        <div class="mb-3">
            <label>Reservation Time</label>
            <input type="time"
                   name="reservation_time"
                   value="{{ $reservation->reservation_time }}"
                   class="form-control"
                   required>
        </div>

        <!-- Guest Count -->
        <div class="mb-3">
            <label>Guest Count</label>
            <input type="number"
                   name="guest_count"
                   value="{{ $reservation->guest_count }}"
                   class="form-control"
                   required>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Pending"
                    {{ $reservation->status == 'Pending' ? 'selected' : '' }}>
                    Pending
                </option>
                <option value="Confirmed"
                    {{ $reservation->status == 'Confirmed' ? 'selected' : '' }}>
                    Confirmed
                </option>
                <option value="Cancelled"
                    {{ $reservation->status == 'Cancelled' ? 'selected' : '' }}>
                    Cancelled
                </option>
            </select>
        </div>

        <!-- Special Request -->
        <div class="mb-3">
            <label>Special Request</label>
            <textarea name="special_request"
                      class="form-control"
                      rows="3">{{ $reservation->special_request }}</textarea>
        </div>

        <button type="submit" class="btn btn-orange">
            Update Reservation
        </button>

        <a href="{{ route('admin.reservations.index') }}"
           class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>

@endsection
