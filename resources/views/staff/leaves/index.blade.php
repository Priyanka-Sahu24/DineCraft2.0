@extends('staff.layout')

@section('content')

<div class="container mt-4">


    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Apply for Leave</h2>
        <div>
            <span class="badge bg-primary me-2">Sick: {{ $leaveBalance['sick'] ?? 0 }}</span>
            <span class="badge bg-success me-2">Paid: {{ $leaveBalance['paid'] ?? 0 }}</span>
            <span class="badge bg-warning text-dark me-2">Casual: {{ $leaveBalance['casual'] ?? 0 }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Apply Leave Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('staff.leaves.apply') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label>Leave Type</label>
                        <select name="type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="sick">Sick</option>
                            <option value="paid">Paid</option>
                            <option value="casual">Casual</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>From Date</label>
                        <input type="date" name="from_date" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>To Date</label>
                        <input type="date" name="to_date" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Supporting Document</label>
                        <input type="file" name="document" class="form-control">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label>Reason</label>
                        <textarea name="reason" class="form-control" rows="2" required></textarea>
                    </div>
                </div>
                <button class="btn btn-orange mt-3">
                    Apply Leave
                </button>
            </form>
        </div>
    </div>

    <!-- Leave History -->
    <h4 class="mb-3">My Leave History</h4>
    <div class="card shadow-sm mb-4">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Reason</th>
                        <th>Document</th>
                        <th>Status</th>
                        <th>Applied On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)
                        <tr @if($leave->status=='pending') style="background:#fffbe6;" @elseif($leave->status=='approved') style="background:#e6ffed;" @elseif($leave->status=='rejected') style="background:#ffe6e6;" @endif>
                            <td>{{ ucfirst($leave->type ?? '-') }}</td>
                            <td>{{ $leave->from_date }}</td>
                            <td>{{ $leave->to_date }}</td>
                            <td>{{ $leave->reason }}</td>
                            <td>
                                @if($leave->document)
                                    <a href="{{ asset('storage/' . $leave->document) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($leave->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($leave->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $leave->created_at->format('d M Y') }}</td>
                            <td>
                                @if($leave->status == 'pending')
                                    <form method="POST" action="{{ route('staff.leaves.cancel', $leave->id) }}" onsubmit="return confirm('Cancel this leave request?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Cancel</button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Leave Records Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection