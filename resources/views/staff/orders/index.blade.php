@extends('staff.layout')

@section('content')


<h2 class="mb-4" style="color:#ff6a00;">My Orders</h2>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search by order #, table..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="preparing" {{ request('status')=='preparing'?'selected':'' }}>Preparing</option>
                    <option value="ready" {{ request('status')=='ready'?'selected':'' }}>Ready</option>
                    <option value="served" {{ request('status')=='served'?'selected':'' }}>Served</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn" style="background:#ff6a00;color:#fff;">Filter</button>
            </div>
        </form>

        <div class="mb-3">
            <span class="badge bg-info">Notifications: No urgent orders.</span>
        </div>

        <table class="table table-bordered align-middle">
            <thead style="background:#ff6a00;color:#fff;">
                <tr>
                    <th>Order #</th>
                    <th>Table</th>
                    <th>Items</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr @if($order->order_status=='pending') style="background:#fffbe6;" @elseif($order->order_status=='preparing') style="background:#e3f2fd;" @elseif($order->order_status=='ready') style="background:#eaffea;" @elseif($order->order_status=='served') style="background:#f3e8ff;" @endif>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}" class="fw-bold text-decoration-underline">#{{ $order->order_number }}</a>
                    </td>
                    <td>{{ $order->table->table_number ?? 'N/A' }}</td>
                    <td>
                        <ul class="mb-0">
                            @foreach($order->items as $item)
                                <li>Qty: {{ $item->quantity }} (₹{{ $item->subtotal }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('staff.orders.updateStatus', $order->id) }}" class="d-inline">
                            @csrf
                            <select name="order_status" class="form-select form-select-sm" style="min-width:110px;display:inline-block;" onchange="this.form.submit()">
                                <option value="pending" {{ $order->order_status=='pending'?'selected':'' }}>Pending</option>
                                <option value="preparing" {{ $order->order_status=='preparing'?'selected':'' }}>Preparing</option>
                                <option value="ready" {{ $order->order_status=='ready'?'selected':'' }}>Ready</option>
                                <option value="served" {{ $order->order_status=='served'?'selected':'' }}>Served</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}" class="btn btn-sm btn-info">Details</a>
                        @if($order->order_status != 'served')
                            <form method="POST" action="{{ route('staff.orders.updateStatus', $order->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">Mark as Completed</button>
                            </form>
                        @else
                            <span class="text-success fw-bold">Completed</span>
                        @endif
                    </td>
                </tr>

                <!-- Order Details Modal -->
                <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">Order #{{ $order->order_number }} Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <p><strong>Table:</strong> {{ $order->table->table_number ?? 'N/A' }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($order->order_status) }}</p>
                        <p><strong>Items:</strong></p>
                        <ul>
                            @foreach($order->items as $item)
                                <li>{{ $item->quantity }} x {{ $item->name ?? '' }} (₹{{ $item->subtotal }})</li>
                            @endforeach
                        </ul>
                        <p><strong>Special Requests:</strong> {{ $order->special_request ?? '-' }}</p>
                        <p><strong>Created At:</strong> {{ $order->created_at->format('d M Y h:i A') }}</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

                @empty
                <tr>
                    <td colspan="5" class="text-center">No orders assigned.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection