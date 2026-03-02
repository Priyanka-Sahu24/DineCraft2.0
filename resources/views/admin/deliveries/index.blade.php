@extends('admin.layouts.admin')

@section('title','Deliveries')

@section('content')


<div class="container mt-4">
    <h2 class="mb-4" style="color:#fd7e14;">Delivery Tracker</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by order, customer, staff..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="assigned" {{ request('status')=='assigned'?'selected':'' }}>Assigned</option>
                <option value="picked_up" {{ request('status')=='picked_up'?'selected':'' }}>Picked Up</option>
                <option value="on_the_way" {{ request('status')=='on_the_way'?'selected':'' }}>On The Way</option>
                <option value="delivered" {{ request('status')=='delivered'?'selected':'' }}>Delivered</option>
                <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn" style="background:#fd7e14;color:#fff;">Filter</button>
        </div>
    </form>

    <form method="POST" action="#">
        @csrf
        <div class="mb-2">
            <select name="bulk_action" class="form-select d-inline-block w-auto">
                <option value="">Bulk Actions</option>
                <option value="assign">Assign Staff</option>
                <option value="mark_delivered">Mark as Delivered</option>
                <option value="mark_cancelled">Mark as Cancelled</option>
                <option value="delete">Delete Selected</option>
            </select>
            <button class="btn ms-2" style="background:#fd7e14;color:#fff;">Apply</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr style="background-color: #fd7e14; color: #fff;">
                        <th><input type="checkbox" onclick="$('input[name=delivery_ids[]]').prop('checked', this.checked)"></th>
                        <th>ID</th>
                        <th>Order No</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Delivery Person</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>ETA</th>
                        <th>Assign/Change Staff</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($deliveries as $delivery)
                    <tr @if($delivery->status=='on_the_way') style="background:#fffbe6;" @elseif($delivery->status=='delivered') style="background:#eaffea;" @elseif($delivery->status=='cancelled') style="background:#fff3f3;" @endif>
                        <td><input type="checkbox" name="delivery_ids[]" value="{{ $delivery->id }}"></td>
                        <td>{{ $delivery->id }}</td>
                        <td>#{{ $delivery->order->order_number ?? 'N/A' }}</td>
                        <td>{{ $delivery->order->user->name ?? 'N/A' }}</td>
                        <td>{{ $delivery->order->user->address ?? 'N/A' }}</td>
                        <td>{{ $delivery->deliveryPerson->employee_id ?? 'N/A' }} - {{ ucfirst($delivery->deliveryPerson->designation ?? '') }}</td>
                        <td>
                            <form method="POST" action="#" class="d-inline">
                                @csrf
                                <select name="status" class="form-select form-select-sm" style="min-width:110px;" onchange="this.form.submit()">
                                    <option value="assigned" {{ $delivery->status=='assigned'?'selected':'' }}>Assigned</option>
                                    <option value="picked_up" {{ $delivery->status=='picked_up'?'selected':'' }}>Picked Up</option>
                                    <option value="on_the_way" {{ $delivery->status=='on_the_way'?'selected':'' }}>On The Way</option>
                                    <option value="delivered" {{ $delivery->status=='delivered'?'selected':'' }}>Delivered</option>
                                    <option value="cancelled" {{ $delivery->status=='cancelled'?'selected':'' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ $delivery->location ?? 'N/A' }}</td>
                        <td>{{ $delivery->estimated_time ? \Carbon\Carbon::parse($delivery->estimated_time)->format('d M Y h:i A') : 'N/A' }}</td>
                        <td>
                            <form method="POST" action="#" class="d-inline">
                                @csrf
                                <select name="delivery_person_id" class="form-select form-select-sm" style="min-width:110px;">
                                    <option value="">Select Staff</option>
                                    {{-- @foreach($deliveryPersons as $staff)
                                        <option value="{{ $staff->id }}" {{ $delivery->delivery_person_id==$staff->id?'selected':'' }}>{{ $staff->employee_id }} - {{ $staff->user->name ?? '' }}</option>
                                    @endforeach --}}
                                </select>
                                <button class="btn btn-sm" style="background:#fd7e14;color:#fff;">Assign</button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.deliveries.show', $delivery->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.deliveries.edit', $delivery->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.deliveries.destroy', $delivery->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted">No deliveries found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </form>
    <a href="{{ route('admin.deliveries.create') }}" class="btn mb-3" style="background:#fd7e14;color:#fff;">Assign Delivery</a>
</div>

@endsection
