@extends('customer.layout')

@section('content')

<div class="container py-5">

    <h2 class="fw-bold text-orange mb-4">
        My Orders 📦
    </h2>

    @if($orders->count() > 0)

    <div class="card shadow border-0 rounded-4 overflow-hidden">

        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order ID</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th width="120">Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach($orders as $order)

                @php
                    $status = strtolower($order->order_status);
                @endphp

                <tr>
                    <td class="fw-semibold">
                        {{ $order->order_number }}
                    </td>

                    <td>
                        {{ ucfirst($order->order_type) }}
                    </td>

                    <td>
                        @if($status == 'pending')
                            <span class="badge bg-warning text-dark px-3 py-2">
                                Pending
                            </span>

                        @elseif($status == 'preparing')
                            <span class="badge bg-info px-3 py-2">
                                Preparing
                            </span>

                        @elseif($status == 'completed')
                            <span class="badge bg-success px-3 py-2">
                                Completed
                            </span>

                        @elseif($status == 'cancelled')
                            <span class="badge bg-danger px-3 py-2">
                                Cancelled
                            </span>

                        @else
                            <span class="badge bg-secondary px-3 py-2">
                                Unknown
                            </span>
                        @endif
                    </td>

                    <td class="fw-semibold">
                        ₹ {{ number_format($order->total_amount ?? 0, 2) }}
                    </td>

                    <td>
                        {{ $order->created_at->format('d M Y') }}
                    </td>

                    <td>

                        {{-- Allow cancel only if pending --}}
                        @if($status == 'pending')

                            <form method="POST"
                                  action="{{ route('order.cancel', $order->id) }}"
                                  onsubmit="return confirm('Are you sure you want to cancel this order?')">

                                @csrf
                                {{-- ❌ Removed DELETE method --}}

                                <button class="btn btn-sm btn-danger">
                                    Cancel
                                </button>

                            </form>

                        @else
                            <span class="text-muted">-</span>
                        @endif

                    </td>

                </tr>

                @endforeach

            </tbody>
        </table>

    </div>

    @else

        <div class="alert alert-info shadow-sm rounded-3">
            You have not placed any orders yet.
        </div>

    @endif

</div>

@endsection