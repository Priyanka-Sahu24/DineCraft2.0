@extends('admin.layouts.admin')

@section('content')

<div class="container">
    <h2>Staff Attendance</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Staff Name</th>
                <th>Date</th>
                <th>Status</th>
                <th>Check In</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->staff->user->name }}</td>
                <td>{{ $attendance->date }}</td>
                <td>{{ ucfirst($attendance->status) }}</td>
                <td>{{ $attendance->check_in }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection