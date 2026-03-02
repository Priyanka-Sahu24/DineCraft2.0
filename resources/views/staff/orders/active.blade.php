@extends('staff.layout')

@section('content')


<h2 class="mb-4" style="color:#ff6a00;">Live Kitchen Board</h2>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="text" name="search" class="form-control" placeholder="Search by order #, customer..." value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">All Status</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="preparing" {{ request('status')=='preparing'?'selected':'' }}>Preparing</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn" style="background:#ff6a00;color:#fff;">Filter</button>
    </div>
</form>

<div class="mb-3">
    <span class="badge bg-info">Notifications: No urgent orders.</span>
</div>

<div class="row">
@forelse($orders as $order)
<div class="col-md-4 mb-4">
    <div class="card p-3 shadow border-0" @if($order->order_status=='pending') style="background:#fffbe6;" @elseif($order->order_status=='preparing') style="background:#e3f2fd;" @endif>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">#{{ $order->order_number }}</h5>
            @if($order->order_status == 'pending')
                <span class="badge bg-secondary">New</span>
            @elseif($order->order_status == 'preparing')
                <span class="badge bg-warning text-dark">Preparing</span>
            @endif
        </div>
        <p class="mb-1"><strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }}</p>
        <p class="mb-1"><strong>Table:</strong> {{ $order->table->table_number ?? 'N/A' }}</p>
        <p class="mb-1"><strong>Contact:</strong> {{ $order->user->phone ?? '-' }}</p>
        <hr>
        <div>
            @foreach($order->items as $item)
                <div class="d-flex justify-content-between">
                    <span>{{ $item->menuItem->name ?? '' }} (x{{ $item->quantity }})</span>
                    <span>₹{{ $item->subtotal }}</span>
                </div>
            @endforeach
        </div>
        <hr>
        <form method="POST" action="{{ route('staff.orders.updateStatus', $order->id) }}">
            @csrf
            <select name="order_status" class="form-select form-select-sm mb-2" onchange="this.form.submit()">
                <option value="pending" {{ $order->order_status=='pending'?'selected':'' }}>Pending</option>
                <option value="preparing" {{ $order->order_status=='preparing'?'selected':'' }}>Preparing</option>
            </select>
            <button class="btn btn-success w-100 mb-2">Print</button>
            <a href="#" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}" class="btn btn-info w-100 mb-2">Details</a>
        </form>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">Order #{{ $order->order_number }} Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }}</p>
        <p><strong>Contact:</strong> {{ $order->user->phone ?? '-' }}</p>
        <p><strong>Table:</strong> {{ $order->table->table_number ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->order_status) }}</p>
        <p><strong>Items:</strong></p>
        <ul>
            @foreach($order->items as $item)
                <li>{{ $item->menuItem->name ?? '' }} x {{ $item->quantity }} (₹{{ $item->subtotal }})</li>
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
    <div class="col-12">
        <div class="alert alert-info text-center">No active orders 🎉</div>
    </div>
@endforelse
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection