@extends('admin.layouts.admin')

@section('title','Add Inventory Item')

@section('content')

<div class="container mt-4">
    <h2 class="mb-4 text-orange">Add Inventory Item</h2>

    <form action="{{ route('admin.inventory.store') }}" method="POST">
        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Item Name</label>
                <input type="text" name="item_name" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Unit (kg, liter, pcs)</label>
                <input type="text" name="unit" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Quantity</label>
                <input type="number" step="0.01" name="quantity" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Low Stock Alert Level</label>
                <input type="number" step="0.01" name="low_alert" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Price (per unit)</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>

            <div class="col-md-12 mb-3">
                <label>Note</label>
                <textarea name="note" class="form-control"></textarea>
            </div>

        </div>

        <button type="submit" class="btn btn-orange">Save Item</button>
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">Back</a>

    </form>
</div>

@endsection
