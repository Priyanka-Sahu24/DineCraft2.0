@extends('staff.layout')

@section('content')

<h2>My Profile</h2>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card p-4">

    <h5>Account Information</h5>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    <hr>

    <h5>Employment Details</h5>
    <p><strong>Employee ID:</strong> {{ $staff->employee_id ?? 'N/A' }}</p>
    <p><strong>Designation:</strong> {{ ucfirst($staff->designation ?? '') }}</p>
    <p><strong>Shift:</strong> {{ ucfirst($staff->shift ?? '') }}</p>
    <p><strong>Joining Date:</strong> {{ $staff->joining_date ?? '' }}</p>
    <p>
        <strong>Status:</strong>
        <span class="badge bg-success">
            {{ ucfirst($staff->status ?? '') }}
        </span>
    </p>

    <a href="{{ route('staff.profile.edit') }}"
       class="btn btn-orange mt-3">
        Edit Profile
    </a>

</div>

@endsection