@extends('admin.layouts.admin')
@section('title','Add Menu Item')
@section('content')

<div class="container mt-4">
    <h2 class="text-orange mb-3">Add New Menu Item</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">--Select Category--</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label>Preparation Time (mins)</label>
            <input type="number" name="preparation_time" class="form-control">
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Availability</label>
            <select name="is_available" class="form-control" required>
                <option value="1">Available</option>
                <option value="0">Not Available</option>
            </select>
        </div>

        <button class="btn btn-orange">Add Menu Item</button>
    </form>
</div>

@endsection
