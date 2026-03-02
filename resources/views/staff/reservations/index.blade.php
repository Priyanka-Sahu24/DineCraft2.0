@extends('staff.layout')

@section('content')

<h2 class="mb-4">Table Reservations</h2>

<div class="card">
<div class="card-body">

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Table</th>
            <th>Date</th>
            <th>Time</th>
            <th>Guests</th>
            <th>Special Request</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($reservations as $reservation)
        <tr>
            <td>{{ $reservation->id }}</td>

            <td>
                {{ $reservation->user->name ?? 'Guest User' }}
            </td>

            <td>
                @if($reservation->table)
                    Table {{ $reservation->table->table_number }}
                    <br>
                    <small>Capacity: {{ $reservation->table->capacity }}</small>
                @else
                    N/A
                @endif
            </td>

            <td>{{ $reservation->reservation_date }}</td>
            <td>{{ $reservation->reservation_time }}</td>
            <td>{{ $reservation->guest_count }}</td>

            <td>
                {{ $reservation->special_request ?? 'None' }}
            </td>

            <td>
                @if($reservation->status == 'pending')
                    <span class="badge bg-secondary">Pending</span>
                @elseif($reservation->status == 'confirmed')
                    <span class="badge bg-info">Confirmed</span>
                @elseif($reservation->status == 'seated')
                    <span class="badge bg-warning text-dark">Seated</span>
                @elseif($reservation->status == 'completed')
                    <span class="badge bg-success">Completed</span>
                @elseif($reservation->status == 'cancelled')
                    <span class="badge bg-danger">Cancelled</span>
                @endif
            </td>

            <td>
                @if(!in_array($reservation->status, ['completed','cancelled']))
                    <form method="POST"
                          action="{{ route('staff.reservations.update',$reservation->id) }}"
                          class="mb-1">
                        @csrf
                        <button class="btn btn-orange btn-sm w-100">
                            Update Status
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('staff.reservations.cancel',$reservation->id) }}">
                        @csrf
                        <button class="btn btn-danger btn-sm w-100">
                            Cancel
                        </button>
                    </form>
                @else
                    <span class="text-muted">No Action</span>
                @endif
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">No reservations found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>
</div>

@endsection