@extends('staff.layout')

@section('content')

<div class="container">
    <div class="card shadow-lg mb-4" style="border-radius:18px;">
        <!-- Removed blue card-header, only white header remains -->
        <div class="card-header bg-white text-dark" style="border-radius:18px 18px 0 0;">
            <h2 class="mb-0">My Attendance</h2>
        </div>
        <div class="card-body">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

            <form method="POST" action="{{ route('staff.attendance.mark') }}">
                @csrf
                <button class="btn btn-success mb-3">Mark Today's Attendance</button>
            </form>
            <form method="POST" action="{{ route('staff.attendance.logout') }}">
                @csrf
                <button class="btn btn-danger mb-3">Logout & Mark Check-out</button>
            </form>

            <hr>

            <table class="table table-bordered align-middle mt-3" style="border-radius:12px; overflow:hidden; box-shadow:0 4px 16px rgba(33,150,243,0.08);">
                <thead>
                    <tr style="background: linear-gradient(90deg, #1976d2 80%, #fff3e0 100%); color: #fff; font-size:1.07rem; letter-spacing:0.5px;">
                        <th>Date</th>
                        <th>Status</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                        <tr @if($attendance->date == date('Y-m-d')) style="background:#e3f2fd; font-weight:600;" @endif>
                            <td>{{ $attendance->date }}</td>
                            <td>{{ ucfirst($attendance->status) }}</td>
                            <td>{{ $attendance->check_in }}</td>
                            <td>{{ $attendance->check_out ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection