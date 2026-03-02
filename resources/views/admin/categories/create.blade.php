@extends('admin.layouts.admin')
@section('title','Add Category')
@section('content')

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>
    <button class="btn btn-orange">Add Category</button>
</form>

@endsection
