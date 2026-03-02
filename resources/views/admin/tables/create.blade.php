@extends('admin.layouts.admin')
@section('title','Add Table')
@section('content')

<div class="container mt-4">
    <h2 class="text-orange mb-3">Add New Table</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

      <form action="{{ route('admin.tables.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Table Number</label>
        <input type="text" name="table_number" class="form-control">
    </div>

    <div class="mb-3">
        <label>Capacity</label>
        <input type="number" name="capacity" class="form-control">
    </div>

    <div class="mb-3">
        <label>Location</label>
        <select name="location" class="form-control">
            <option value="Indoor">Indoor</option>
            <option value="Outdoor">Outdoor</option>
            <option value="Rooftop">Rooftop</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="available">Available</option>
            <option value="occupied">Occupied</option>
            <option value="reserved">Reserved</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Add Table
    </button>

</form>
</div>

@endsection
