@extends('admin.layouts.admin')
@section('title','Manage Staff')
@section('content')


<div class="container mt-4">
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-orange text-white d-flex justify-content-between align-items-center">
              <h4 class="mb-0" style="color: #fd7e14;">Staff Management</h4>
            <a href="{{ route('admin.staff.create') }}" class="btn btn-orange">➕ Add Staff</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <!-- Search/Filter Form -->
            <form method="GET" class="row mb-3">
                <div class="col-md-3 mb-2">
                    <input type="text" name="search_name" class="form-control" placeholder="Search by Name" value="{{ request('search_name') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <select name="filter_designation" class="form-select">
                        <option value="">All Designations</option>
                        @php $designations = $staffs->pluck('designation')->unique()->filter(); @endphp
                        @foreach($designations as $designation)
                            <option value="{{ $designation }}" {{ request('filter_designation') == $designation ? 'selected' : '' }}>{{ ucfirst($designation) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <select name="filter_status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('filter_status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('filter_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <button class="btn btn-orange w-100">Search</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-orange">
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Emergency Contact</th>
                            <th>Role/Position</th>
                            <th>Employment Status</th>
                            <th>Joining Date</th>
                            <th>Work History</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffs as $staff)
                        <tr>
                            <td><span class="fw-bold text-orange">{{ $staff->user->name }}</span></td>
                            <td>{{ $staff->user->phone }}</td>
                            <td>{{ $staff->user->address }}</td>
                            <td>
                                <span class="d-block">{{ $staff->user->emergency_contact_name }}</span>
                                <span class="small text-muted">{{ $staff->user->emergency_contact_phone }}</span>
                            </td>
                            <td>{{ ucfirst($staff->designation) }}</td>
                            <td>
                                <span class="badge bg-orange text-white">{{ ucfirst($staff->status) }}</span>
                            </td>
                            <td>{{ $staff->joining_date }}</td>
                            <td><a href="#" class="btn btn-sm btn-info">View</a></td>
                            <td>
                                <a href="{{ route('admin.staff.edit',$staff->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                <form action="{{ route('admin.staff.destroy',$staff->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger mb-1">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
