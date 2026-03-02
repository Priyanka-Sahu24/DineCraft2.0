@extends('admin.layouts.admin')
@section('title','Create Order')
@section('content')

<div class="container mt-4">
    <h2>Create Order</h2>

    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Customer</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Table</label>
            <select name="table_id" class="form-control">
                <option value="">Select Table</option>
                @foreach($tables as $table)
                    <option value="{{ $table->id }}">
                        Table {{ $table->table_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Staff</label>
            <select name="staff_id" class="form-control">
                <option value="">Assign Staff</option>
                @foreach($staff as $s)
                    <option value="{{ $s->id }}">
                        {{ $s->employee_id }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Order Type</label>
            <select name="order_type" class="form-control" required>
                <option value="Dine-In">Dine-In</option>
                <option value="Takeaway">Takeaway</option>
                <option value="Delivery">Delivery</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="order_status" class="form-control" required>
                <option value="Pending">Pending</option>
                <option value="Preparing">Preparing</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>

        <button class="btn btn-orange">Save Order</button>
    </form>
</div>

@endsection
