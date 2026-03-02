@extends('staff.layout')

@section('content')

<h2>Edit Profile</h2>

<form method="POST" action="{{ route('staff.profile.update') }}">
@csrf

<div class="card p-4">

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name"
               value="{{ $user->name }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email"
               value="{{ $user->email }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Shift</label>
        <select name="shift" class="form-control">
            <option value="morning" {{ $staff->shift == 'morning' ? 'selected' : '' }}>Morning</option>
            <option value="evening" {{ $staff->shift == 'evening' ? 'selected' : '' }}>Evening</option>
        </select>
    </div>

    <hr>

    <div class="mb-3">
        <label>New Password (Optional)</label>
        <input type="password" name="password"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation"
               class="form-control">
    </div>

    <button class="btn btn-orange">
        Update Profile
    </button>

</div>
</form>

@endsection