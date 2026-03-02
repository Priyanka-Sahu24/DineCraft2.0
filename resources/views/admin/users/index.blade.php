@extends('admin.layouts.admin')

@section('title','Users')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4" style="color:#fd7e14;">User Management</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by name, email..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
                <option value="staff" {{ request('role')=='staff'?'selected':'' }}>Staff</option>
                <option value="customer" {{ request('role')=='customer'?'selected':'' }}>Customer</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
                <option value="banned" {{ request('status')=='banned'?'selected':'' }}>Banned</option>
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
                <option value="activate">Activate</option>
                <option value="deactivate">Deactivate</option>
                <option value="ban">Ban</option>
                <option value="delete">Delete</option>
                <option value="assign_role">Assign Role</option>
            </select>
            <button class="btn ms-2" style="background:#fd7e14;color:#fff;">Apply</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" style="border-radius:18px; overflow:hidden; box-shadow:0 8px 32px rgba(253,126,20,0.13);">
                <thead>
                    <tr style="background: linear-gradient(90deg, #fd7e14 80%, #fff3e0 100%); color: #fff; font-size:1.07rem; letter-spacing:0.5px;">
                        <th><input type="checkbox" onclick="$('input[name=user_ids[]]').prop('checked', this.checked)"></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr style="transition:background 0.18s;">
                        <td><input type="checkbox" name="user_ids[]" value="{{ $user->id }}"></td>
                        <td style="font-weight:600; color:#fd7e14;">{{ $user->id }}</td>
                        <td style="font-weight:500;">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>{{ $user->address ?? '-' }}</td>
                        <td>
                            @foreach($user->getRoleNames() as $role)
                                <span class="badge bg-info" style="background:#fd7e14;color:#fff;font-weight:600;">{{ ucfirst($role) }}</span>
                            @endforeach
                        </td>
                        <td>
                            <form method="POST" action="#" class="d-inline">
                                @csrf
                                <select name="status" class="form-select form-select-sm" style="min-width:100px;">
                                    <option value="active" {{ $user->status=='active'?'selected':'' }}>Active</option>
                                    <option value="inactive" {{ $user->status=='inactive'?'selected':'' }}>Inactive</option>
                                    <option value="banned" {{ $user->status=='banned'?'selected':'' }}>Banned</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info" style="border-radius:8px;">View</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary" style="border-radius:8px;">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" style="border-radius:8px;" onclick="return confirm('Delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No users found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <style>
            .table tbody tr:hover {
                background: #fff7ef !important;
                box-shadow: 0 2px 12px rgba(253,126,20,0.08);
                transition: background 0.18s, box-shadow 0.18s;
            }
            .table th, .table td {
                padding: 14px 16px !important;
                vertical-align: middle;
            }
            </style>
        </div>
    </form>
    <a href="{{ route('admin.users.create') }}" class="btn mb-3" style="background:#fd7e14;color:#fff;">+ Add User</a>
</div>
@endsection
