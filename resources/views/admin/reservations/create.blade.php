@extends('admin.layouts.admin')
@section('title','Add Reservation')

@section('content')

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-body">

            <h3 class="mb-4 fw-bold">Create Reservation</h3>

            <form action="{{ route('admin.reservations.store') }}"
                  method="POST">
                @csrf

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- User --}}
                <div class="mb-3">
                    <label class="form-label">Select Customer</label>
                    <select name="user_id" class="form-select" required>
                        <option value="">-- Choose User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Table --}}
                <div class="mb-3">
                    <label class="form-label">Select Table</label>
                    <select name="table_id" class="form-select" required>
                        <option value="">-- Choose Table --</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}">
                                Table {{ $table->table_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Date --}}
                <div class="mb-3">
                    <label class="form-label">Reservation Date</label>
                    <input type="date"
                           name="reservation_date"
                           class="form-control"
                           required>
                </div>

                {{-- Time --}}
                <div class="mb-3">
                    <label class="form-label">Reservation Time</label>
                    <input type="time"
                           name="reservation_time"
                           class="form-control"
                           required>
                </div>

                {{-- Guests --}}
                <div class="mb-3">
                    <label class="form-label">Guest Count</label>
                    <input type="number"
                           name="guest_count"
                           min="1"
                           class="form-control"
                           required>
                </div>

                {{-- Special Request --}}
                <div class="mb-3">
                    <label class="form-label">Special Request</label>
                    <textarea name="special_request"
                              class="form-control"
                              rows="3"></textarea>
                </div>

                <button type="submit"
                        class="btn btn-warning text-white">
                    Save Reservation
                </button>

                <a href="{{ route('admin.reservations.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>
    </div>

</div>

@endsection