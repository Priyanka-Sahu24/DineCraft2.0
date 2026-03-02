@extends('admin.layouts.admin')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 fw-bold" style="color:#ff6a00;">Add New User</h3>
    <div class="card p-4 shadow border-0">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @include('admin.users.form')
            <div class="mt-4">
                <button type="submit" class="btn btn-orange">Create User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
