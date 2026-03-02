@extends('admin.layouts.admin')
@section('title','Admin Profile')
@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-orange text-white">
              <h4 class="mb-0" style="color: #fd7e14;">Admin Profile</h4>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <!-- Add more profile fields as needed -->
        </div>
    </div>
</div>
@endsection
