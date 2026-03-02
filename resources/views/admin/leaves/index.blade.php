@extends('admin.layouts.admin')

@section('content')


<div class="container py-4">
    <h3 class="mb-4 fw-bold" style="color:#ff6a00; letter-spacing:1px;">Staff Leave Management</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card p-4 shadow border-0" style="border-radius:18px; background:linear-gradient(120deg,#fff7f0 80%,#fff1e6 100%);">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="fw-semibold fs-5" style="color:#222;">Leave Applications</span>
            <form method="GET" class="d-flex" style="gap:10px;">
                <input type="text" name="search" class="form-control" placeholder="Search by staff name..." value="{{ request('search') }}" style="max-width:220px;">
                <select name="status" class="form-select" style="max-width:140px;">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button class="btn btn-orange px-3">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
        <table class="table table-hover align-middle" style="background:#fff; border-radius:12px; overflow:hidden;">
            <thead style="background:linear-gradient(90deg,#ff6a00 60%,#ff8800 100%); color:#fff;">
                <tr>
                    <th style="border:none;">Staff Name</th>
                    <th style="border:none;">From</th>
                    <th style="border:none;">To</th>
                    <th style="border:none;">Reason</th>
                    <th style="border:none;">Status</th>
                    <th style="border:none;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                <tr style="vertical-align:middle;">
                    <td class="fw-semibold">{{ $leave->staff->user->name }}</td>
                    <td>{{ $leave->from_date }}</td>
                    <td>{{ $leave->to_date }}</td>
                    <td>{{ $leave->reason }}</td>
                    <td>
                        @if($leave->status == 'pending')
                            <span class="badge" style="background:linear-gradient(90deg,#ffb300 60%,#ff8800 100%); color:#fff;">Pending</span>
                        @elseif($leave->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        @if($leave->status == 'pending')
                            <a href="{{ route('admin.leaves.approve', $leave->id) }}" class="btn btn-success btn-sm me-1" style="border-radius:8px;">Approve</a>
                            <a href="{{ route('admin.leaves.reject', $leave->id) }}" class="btn btn-danger btn-sm" style="border-radius:8px;">Reject</a>
                        @else
                            <span class="text-muted">No Action</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No Leave Applications Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

@endsection