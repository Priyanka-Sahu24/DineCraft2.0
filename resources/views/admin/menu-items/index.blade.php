@extends('admin.layouts.admin')
@section('title','Menu Items')
@section('content')


<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-orange">Menu Items</h2>
        <a href="{{ route('admin.menu-items.create') }}" class="btn btn-orange">Add New Menu Item</a>
    </div>


    <div class="container mt-4">
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-orange text-white d-flex flex-wrap justify-content-between align-items-center">
                <h4 class="mb-0" style="color: #ff6a00;">Menu Items</h4>
                <form method="GET" class="d-flex align-items-center mb-2 mb-md-0" style="gap: 8px;">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name or category..." value="{{ request('search') }}" style="max-width: 200px;">
                    <button class="btn btn-orange btn-sm">Search</button>
                </form>
                <a href="{{ route('admin.menu-items.create') }}" class="btn btn-orange">➕ Add New Menu Item</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('admin.menu-items.bulkAction') }}">
                    @csrf
                    <div class="mb-2">
                        <select name="bulk_action" class="form-select d-inline-block w-auto">
                            <option value="">Bulk Actions</option>
                            <option value="delete">Delete Selected</option>
                            <option value="activate">Activate Selected</option>
                            <option value="deactivate">Deactivate Selected</option>
                        </select>
                        <button class="btn btn-orange ms-2">Apply</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-orange">
                                <tr>
                                    <th><input type="checkbox" onclick="$('input[name=menu_item_ids[]]').prop('checked', this.checked)"></th>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Preparation Time</th>
                                    <th>Availability</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($menuItems as $item)
                                <tr @if(!$item->is_available) style="background:#fff3f3;" @endif>
                                    <td><input type="checkbox" name="menu_item_ids[]" value="{{ $item->id }}"></td>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" width="60" height="60" style="object-fit:cover; border-radius:6px;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->category->name ?? 'N/A' }}</td>
                                    <td><span class="fw-bold text-orange">{{ $item->name }}</span>
                                        <button type="button" class="btn btn-link btn-sm p-0 ms-1" data-bs-toggle="modal" data-bs-target="#menuModal{{ $item->id }}">View</button>
                                    </td>
                                    <td>₹ {{ $item->price }}</td>
                                    <td>{{ $item->preparation_time ? $item->preparation_time . ' min' : '-' }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input availability-toggle" type="checkbox" data-id="{{ $item->id }}" {{ $item->is_available ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                <span class="badge {{ $item->is_available ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $item->is_available ? 'Available' : 'Not Available' }}
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.menu-items.edit', $item->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                        <form action="{{ route('admin.menu-items.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger mb-1">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Menu Item Details Modal -->
                                <div class="modal fade" id="menuModal{{ $item->id }}" tabindex="-1" aria-labelledby="menuModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="menuModalLabel{{ $item->id }}">Menu Item Details (#{{ $item->id }})</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Name:</strong> {{ $item->name }}</p>
                                                <p><strong>Category:</strong> {{ $item->category->name ?? 'N/A' }}</p>
                                                <p><strong>Description:</strong> {{ $item->description }}</p>
                                                <p><strong>Price:</strong> ₹ {{ $item->price }}</p>
                                                <p><strong>Preparation Time:</strong> {{ $item->preparation_time ? $item->preparation_time . ' min' : '-' }}</p>
                                                <p><strong>Status:</strong> {{ $item->is_available ? 'Available' : 'Not Available' }}</p>
                                                @if($item->image)
                                                    <img src="{{ asset('storage/' . $item->image) }}" width="120" height="120" style="object-fit:cover; border-radius:10px;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No menu items found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($menuItems->hasPages())
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $menuItems->links() }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
