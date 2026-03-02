@extends('admin.layouts.admin')

@section('title','Deliveries')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4 text-orange">Delivery Tracker</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.deliveries.create') }}"
       class="btn btn-orange mb-3">
        Assign Delivery
    </a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark text-white">
        <tr>
            <th>ID</th>
            <th>Order No</th>
            <th>Delivery Person</th>
            <th>Status</th>
            <th>Location</th>
            <th>ETA</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @forelse($deliveries as $delivery)
            <tr>
                <!-- ID -->
                <td>{{ $delivery->id }}</td>

                <!-- Order -->
                <td>#{{ $delivery->order->order_number ?? 'N/A' }}</td>

                <!-- Delivery Person -->
                <td>{{ $delivery->deliveryPerson->user->name ?? 'N/A' }}</td>

                <!-- Status -->
                <td>
                    <span class="badge 
                        @if($delivery->status == 'assigned') bg-secondary
                        @elseif($delivery->status == 'picked_up') bg-primary
                        @elseif($delivery->status == 'on_the_way') bg-warning text-dark
                        @elseif($delivery->status == 'delivered') bg-success
                        @else bg-danger
                        @endif">
                        {{ ucwords(str_replace('_',' ',$delivery->status)) }}
                    </span>
                </td>

                <!-- Location -->
                <td>
                    {{ $delivery->location ?? 'Not Set' }}
                </td>

                <!-- Estimated Time -->
                <td>
                    {{ $delivery->estimated_time 
                        ? \Carbon\Carbon::parse($delivery->estimated_time)->format('d M Y h:i A') 
                        : 'N/A' }}
                </td>

                <!-- Actions -->
                <td>
                    <a href="{{ route('admin.deliveries.edit', $delivery->id) }}"
                       class="btn btn-sm btn-primary">Edit</a>

                    <form action="{{ route('admin.deliveries.destroy', $delivery->id) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">No deliveries found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@endsection
