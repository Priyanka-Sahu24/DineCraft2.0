@extends('admin.layouts.admin')
@section('title','Edit Menu Item')
@section('content')

<div class="container mt-4">
    <h2 class="text-orange mb-3">Edit Menu Item</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.menu-items.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">--Select Category--</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $menuItem->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $menuItem->name }}" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $menuItem->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" step="0.01" value="{{ $menuItem->price }}" required>
        </div>

        <div class="mb-3">
            <label>Preparation Time (mins)</label>
            <input type="number" name="preparation_time" class="form-control" value="{{ $menuItem->preparation_time }}">
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            @if($menuItem->image)
                <img src="{{ asset('storage/'.$menuItem->image) }}" width="100" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label>Availability</label>
            <select name="is_available" class="form-control" required>
                <option value="1" {{ $menuItem->is_available ? 'selected' : '' }}>Available</option>
                <option value="0" {{ !$menuItem->is_available ? 'selected' : '' }}>Not Available</option>
            </select>
        </div>

        <button class="btn btn-orange">Update Menu Item</button>
    </form>
</div>

@endsection
