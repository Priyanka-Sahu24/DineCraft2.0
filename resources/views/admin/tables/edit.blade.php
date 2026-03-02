@extends('admin.layouts.admin')
@section('title','Edit Table')
@section('content')

<div class="container mt-4">
    <h2 class="text-orange mb-3">Edit Table</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.tables.update',$table->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $table->name }}" required>
        </div>
        <div class="mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" class="form-control" value="{{ $table->capacity }}" required min="1">
        </div>
        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="{{ $table->location }}" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="available" {{ $table->status=='available'?'selected':'' }}>Available</option>
                <option value="occupied" {{ $table->status=='occupied'?'selected':'' }}>Occupied</option>
                <option value="reserved" {{ $table->status=='reserved'?'selected':'' }}>Reserved</option>
            </select>
        </div>
        <button class="btn btn-orange">Update Table</button>
    </form>
</div>

@endsection
