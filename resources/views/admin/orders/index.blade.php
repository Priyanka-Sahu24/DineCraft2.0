@extends('admin.layouts.admin')
@section('title','Orders')
@section('content')


<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-orange">Orders Management</h2>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-orange">Create Order</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by order no, customer..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                <option value="Preparing" {{ request('status')=='Preparing'?'selected':'' }}>Preparing</option>
                <option value="Completed" {{ request('status')=='Completed'?'selected':'' }}>Completed</option>
                <option value="Cancelled" {{ request('status')=='Cancelled'?'selected':'' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="type" class="form-select">
                <option value="">All Types</option>
                <option value="Dine-In" {{ request('type')=='Dine-In'?'selected':'' }}>Dine-In</option>
                <option value="Takeaway" {{ request('type')=='Takeaway'?'selected':'' }}>Takeaway</option>
                <option value="Delivery" {{ request('type')=='Delivery'?'selected':'' }}>Delivery</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-orange w-100">Filter</button>
        </div>
    </form>

    <form method="POST" action="#">
        @csrf
        <div class="mb-2">
            <select name="bulk_action" class="form-select d-inline-block w-auto">
                <option value="">Bulk Actions</option>
                <option value="delete">Delete Selected</option>
                <option value="mark_completed">Mark as Completed</option>
                <option value="mark_preparing">Mark as Preparing</option>
                <option value="mark_cancelled">Mark as Cancelled</option>
            </select>
            <button class="btn btn-orange ms-2">Apply</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-orange">
                    <tr>
                        <th><input type="checkbox" onclick="$('input[name=order_ids[]]').prop('checked', this.checked)"></th>
                        <th>ID</th>
                        <th>Order No</th>
                        <th>Customer</th>
                        <th>Table</th>
                        <th>Staff</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr @if($order->order_status=='Pending') style="background:#fffbe6;" @elseif($order->order_status=='Cancelled') style="background:#fff3f3;" @endif>
                        <td><input type="checkbox" name="order_ids[]" value="{{ $order->id }}"></td>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ $order->table->table_number ?? '-' }}</td>
                        <td>{{ $order->staff->employee_id ?? '-' }}</td>
                        <td>{{ $order->order_type }}</td>
                        <td>
                            <form method="POST" action="#" class="d-inline">
                                @csrf
                                <select name="order_status" class="form-select form-select-sm" style="min-width:110px;" onchange="this.form.submit()">
                                    <option value="Pending" {{ $order->order_status=='Pending'?'selected':'' }}>Pending</option>
                                    <option value="Preparing" {{ $order->order_status=='Preparing'?'selected':'' }}>Preparing</option>
                                    <option value="Completed" {{ $order->order_status=='Completed'?'selected':'' }}>Completed</option>
                                    <option value="Cancelled" {{ $order->order_status=='Cancelled'?'selected':'' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show',$order->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.orders.edit',$order->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.orders.destroy',$order->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>

@endsection
