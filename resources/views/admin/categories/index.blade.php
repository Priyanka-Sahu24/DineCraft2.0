@extends('admin.layouts.admin')
@section('title','Categories')
@section('content')



<div class="container mt-4">
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-orange text-white d-flex flex-wrap justify-content-between align-items-center">
            <h4 class="mb-0" style="color: #ff6a00;">Category Management</h4>
            <form method="GET" class="d-flex align-items-center mb-2 mb-md-0" style="gap: 8px;">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search category..." value="{{ request('search') }}" style="max-width: 200px;">
                <button class="btn btn-orange btn-sm">Search</button>
            </form>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-orange">➕ Add Category</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.bulkAction') }}">
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
                                <th><input type="checkbox" onclick="$('input[name=category_ids[]]').prop('checked', this.checked)"></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Menu Items</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td><input type="checkbox" name="category_ids[]" value="{{ $category->id }}"></td>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <span class="fw-bold text-orange">{{ $category->name }}</span>
                                    <button type="button" class="btn btn-link btn-sm p-0 ms-1" data-bs-toggle="modal" data-bs-target="#catModal{{ $category->id }}">View</button>
                                </td>
                                <td>{{ $category->description }}</td>
                                <td>
                                    <form action="{{ route('admin.categories.toggleStatus', $category->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $category->status ? 'btn-success' : 'btn-secondary' }}">{{ $category->status ? 'Active' : 'Inactive' }}</button>
                                    </form>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $category->menu_items_count ?? $category->menuItems->count() }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.edit',$category->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                    <form action="{{ route('admin.categories.destroy',$category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger mb-1">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Category Details Modal -->
                            <div class="modal fade" id="catModal{{ $category->id }}" tabindex="-1" aria-labelledby="catModalLabel{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="catModalLabel{{ $category->id }}">Category Details (#{{ $category->id }})</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Name:</strong> {{ $category->name }}</p>
                                            <p><strong>Description:</strong> {{ $category->description }}</p>
                                            <p><strong>Status:</strong> {{ $category->status ? 'Active' : 'Inactive' }}</p>
                                            <p><strong>Menu Items:</strong> {{ $category->menu_items_count ?? $category->menuItems->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No categories found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($categories->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $categories->links() }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

@endsection
