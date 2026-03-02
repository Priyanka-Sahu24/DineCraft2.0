@extends('admin.layouts.admin')

@section('title','Edit Inventory Item')

@section('content')

<div class="container mt-4">
    <h2 class="mb-4 text-orange">Edit Inventory Item</h2>

    <form action="{{ route('admin.inventory.update',$inventory->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Item Name</label>
                <input type="text" name="item_name"
                       value="{{ $inventory->item_name }}"
                       class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Unit</label>
                <input type="text" name="unit"
                       value="{{ $inventory->unit }}"
                       class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Quantity</label>
                <input type="number" step="0.01"
                       name="quantity"
                       value="{{ $inventory->quantity }}"
                       class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Low Alert</label>
                <input type="number" step="0.01"
                       name="low_alert"
                       value="{{ $inventory->low_alert }}"
                       class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Price</label>
                <input type="number" step="0.01"
                       name="price"
                       value="{{ $inventory->price }}"
                       class="form-control" required>
            </div>

            <div class="col-md-12 mb-3">
                <label>Note</label>
                <textarea name="note"
                          class="form-control">{{ $inventory->note }}</textarea>
            </div>

        </div>

        <button type="submit" class="btn btn-orange">Update Item</button>
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">Back</a>

    </form>
</div>

@endsection
