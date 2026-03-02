@extends('admin.layouts.admin')
@section('title','Manage Tables')
@section('content')

<div class="container mt-4" style="margin-left:260px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-orange">Table List</h2>
        <div>
            <a href="{{ route('admin.tables.create') }}" class="btn btn-orange">Add Table</a>
            <a href="{{ route('admin.tables.export', ['type' => 'csv']) }}" class="btn btn-success ms-2">Export CSV</a>
            <a href="{{ route('admin.tables.export', ['type' => 'pdf']) }}" class="btn btn-danger ms-2">Export PDF</a>
        </div>
    </div>

    <form method="GET" class="mb-3 d-flex" style="gap:10px;">
        <input type="text" name="search" class="form-control" placeholder="Search by table number (e.g. T1)" value="{{ request('search') }}" style="max-width:220px;">
        <button class="btn btn-orange px-3">Search</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.tables.bulkAction') }}">
        @csrf
        <div class="mb-2">
            <select name="bulk_action" class="form-select d-inline-block w-auto">
                <option value="">Bulk Actions</option>
                <option value="delete">Delete Selected</option>
                <option value="available">Set as Available</option>
                <option value="occupied">Set as Occupied</option>
                <option value="reserved">Set as Reserved</option>
            </select>
            <button class="btn btn-orange ms-2">Apply</button>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-orange">
                <tr>
                    <th><input type="checkbox" onclick="$('input[name=table_ids[]]').prop('checked', this.checked)"></th>
                    <th>ID</th>
                    <th>Capacity</th>
                    <th>Location</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tables as $table)
                <tr>
                    <td><input type="checkbox" name="table_ids[]" value="{{ $table->id }}"></td>
                    <td>{{ $table->id }}</td>
                    <td>{{ $table->capacity }}</td>
                    <td>{{ ucfirst($table->location) }}</td>
                    @php $cat = $categories[$table->id % count($categories)] ?? 'Normal'; @endphp
                    <td>{{ $cat }}</td>
                    <td>₹{{ $prices[$cat] ?? 300 }}</td>
                    <td>
                        @if($table->status == 'available')
                            <span class="badge bg-success">Available</span>
                        @elseif($table->status == 'occupied')
                            <span class="badge bg-warning text-dark">Occupied</span>
                        @elseif($table->status == 'reserved')
                            <span class="badge bg-danger">Reserved</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($table->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#tableModal{{ $table->id }}">View</button>
                        <a href="{{ route('admin.tables.edit',$table->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.tables.destroy',$table->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <!-- Table Details Modal -->
                <div class="modal fade" id="tableModal{{ $table->id }}" tabindex="-1" aria-labelledby="tableModalLabel{{ $table->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tableModalLabel{{ $table->id }}">Table Details (#{{ $table->id }})</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Capacity:</strong> {{ $table->capacity }}</p>
                                <p><strong>Location:</strong> {{ ucfirst($table->location) }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($table->status) }}</p>
                                <p><strong>Table Number:</strong> {{ $table->table_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        @if($tables->hasPages())
            <div class="mt-3 d-flex justify-content-center">
                {{ $tables->links() }}
            </div>
        @endif
    </form>
    @if($tables->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $tables->links() }}
        </div>
    @endif
</div>

@endsection
