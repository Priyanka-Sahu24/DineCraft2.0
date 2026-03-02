@extends('admin.layouts.admin')

@section('title','Edit Order')

@section('content')

<div class="container mt-4">
    <h2 class="mb-4 text-orange">Edit Order</h2>

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Order Number</label>
                <input type="text" name="order_number" class="form-control"
                       value="{{ old('order_number', $order->order_number) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Customer</label>
                <select name="user_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ $order->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Table</label>
                <select name="table_id" class="form-control">
                    <option value="">-- No Table --</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}"
                            {{ $order->table_id == $table->id ? 'selected' : '' }}>
                            Table {{ $table->table_number }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Order Type</label>
                <select name="order_type" class="form-control" required>
                    <option value="Dine-In" {{ $order->order_type == 'Dine-In' ? 'selected' : '' }}>Dine-In</option>
                    <option value="Takeaway" {{ $order->order_type == 'Takeaway' ? 'selected' : '' }}>Takeaway</option>
                    <option value="Delivery" {{ $order->order_type == 'Delivery' ? 'selected' : '' }}>Delivery</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Order Status</label>
                <select name="order_status" class="form-control" required>
                    <option value="Pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Preparing" {{ $order->order_status == 'Preparing' ? 'selected' : '' }}>Preparing</option>
                    <option value="Completed" {{ $order->order_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ $order->order_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

        </div>

        <button type="submit" class="btn btn-orange">Update Order</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>

    </form>
</div>

@endsection