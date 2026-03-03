@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>User Details</h2>
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
            <p class="card-text"><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</p>
            <p class="card-text"><strong>Created At:</strong> {{ $user->created_at }}</p>
            <p class="card-text"><strong>Updated At:</strong> {{ $user->updated_at }}</p>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-2">Back to Users</a>
        </div>
    </div>
</div>
@endsection
