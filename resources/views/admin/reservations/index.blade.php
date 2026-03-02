@extends('admin.layouts.admin')
@section('title','Reservations')
@section('content')

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by customer, table..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                        <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>Confirmed</option>
                        <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                        <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn w-100" style="background-color: #fd7e14; color: #fff; border: 1px solid #fd7e14;">Filter</button>
                </div>
            </form>
            <form method="POST" action="#">
                @csrf
                <div class="mb-2">
                    <select name="bulk_action" class="form-select d-inline-block w-auto">
                        <option value="">Bulk Actions</option>
                        <option value="confirm">Confirm Selected</option>
                        <option value="complete">Mark as Completed</option>
                        <option value="cancel">Cancel Selected</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button class="btn ms-2" style="background-color: #fd7e14; color: #fff; border: 1px solid #fd7e14;">Apply</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr style="background-color: #fd7e14; color: #222;">
                                <th style="background-color: #fd7e14; color: #222;"><input type="checkbox" onclick="$('input[name=reservation_ids[]]').prop('checked', this.checked)"></th>
                                <th style="background-color: #fd7e14; color: #222;">ID</th>
                                <th style="background-color: #fd7e14; color: #222;">Customer</th>
                                <th style="background-color: #fd7e14; color: #222;">Table</th>
                                <th style="background-color: #fd7e14; color: #222;">Date</th>
                                <th style="background-color: #fd7e14; color: #222;">Time</th>
                                <th style="background-color: #fd7e14; color: #222;">Guests</th>
                                <th style="background-color: #fd7e14; color: #222;">Special Request</th>
                                <th style="background-color: #fd7e14; color: #222;">Status</th>
                                <th style="background-color: #fd7e14; color: #222;" width="180">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($reservations as $reservation)
                            <tr @if($reservation->status=='pending') style="background:#fffbe6;" @elseif($reservation->status=='cancelled') style="background:#fff3f3;" @endif>
                                <td><input type="checkbox" name="reservation_ids[]" value="{{ $reservation->id }}"></td>
                                <td>#{{ $reservation->id }}</td>
                                <td>
                                    <div><strong>{{ $reservation->user->name ?? 'N/A' }}</strong></div>
                                    @if($reservation->user)
                                        <div class="small text-muted">{{ $reservation->user->email }}</div>
                                        <div class="small text-muted">{{ $reservation->user->phone ?? '-' }}</div>
                                        <div class="small text-muted">{{ $reservation->user->address ?? '-' }}</div>
                                    @endif
                                </td>
                                <td>Table {{ $reservation->table->table_number ?? 'N/A' }}</td>
                                <td>{{ $reservation->reservation_date }}</td>
                                <td>{{ $reservation->reservation_time }}</td>
                                <td>{{ $reservation->guest_count }}</td>
                                <td>{{ $reservation->special_request ?? '-' }}</td>
                                <td>
                                    <form method="POST" action="#" class="d-inline">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm" style="min-width:110px;" onchange="this.form.submit()">
                                            <option value="pending" {{ $reservation->status=='pending'?'selected':'' }}>Pending</option>
                                            <option value="confirmed" {{ $reservation->status=='confirmed'?'selected':'' }}>Confirmed</option>
                                            <option value="completed" {{ $reservation->status=='completed'?'selected':'' }}>Completed</option>
                                            <option value="cancelled" {{ $reservation->status=='cancelled'?'selected':'' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.reservations.edit',$reservation->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.reservations.destroy',$reservation->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this reservation?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    No reservations found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection