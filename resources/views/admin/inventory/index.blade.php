@extends('admin.layouts.admin')

@section('title','Inventory')

@section('content')


<div class="container mt-4">
    <h2 class="mb-4" style="color:#fd7e14;">Inventory Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by item name..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="low" {{ request('status')=='low'?'selected':'' }}>Low Stock</option>
                <option value="in" {{ request('status')=='in'?'selected':'' }}>In Stock</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn" style="background:#fd7e14;color:#fff;">Filter</button>
        </div>
    </form>

    <form method="POST" action="#">
        @csrf
        <div class="mb-2">
            <select name="bulk_action" class="form-select d-inline-block w-auto">
                <option value="">Bulk Actions</option>
                <option value="delete">Delete Selected</option>
                <option value="set_low">Mark as Low Stock</option>
                <option value="set_in">Mark as In Stock</option>
            </select>
            <button class="btn ms-2" style="background:#fd7e14;color:#fff;">Apply</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr style="background-color: #fd7e14; color: #fff;">
                        <th><input type="checkbox" onclick="$('input[name=inventory_ids[]]').prop('checked', this.checked)"></th>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Low Alert</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Quick Adjust</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr @if($item->quantity <= $item->low_alert) style="background:#fff3f3;" @endif>
                        <td><input type="checkbox" name="inventory_ids[]" value="{{ $item->id }}"></td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->low_alert }}</td>
                        <td>₹ {{ $item->price }}</td>
                        <td>
                            @if($item->quantity <= $item->low_alert)
                                <span class="badge bg-danger">Low Stock</span>
                            @else
                                <span class="badge bg-success">In Stock</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="#" class="d-inline">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <input type="number" name="adjust_qty" class="form-control form-control-sm d-inline-block" style="width:70px;" placeholder="Qty">
                                <button class="btn btn-sm" style="background:#fd7e14;color:#fff;">Update</button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.inventory.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.inventory.destroy',$item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete item?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No inventory items found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </form>
    <a href="{{ route('admin.inventory.create') }}" class="btn mb-3" style="background:#fd7e14;color:#fff;">+ Add Item</a>
</div>

@endsection
