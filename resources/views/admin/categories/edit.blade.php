@extends('admin.layouts.admin')
@section('title','Edit Category')
@section('content')

<form action="{{ route('admin.categories.update',$category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required>{{ $category->description }}</textarea>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="1" {{ $category->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$category->status ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <button class="btn btn-orange">Update Category</button>
</form>

@endsection
