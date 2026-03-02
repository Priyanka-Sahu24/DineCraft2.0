@extends('admin.layouts.admin')
@section('title','Edit Staff')
@section('content')

<div class="container mt-4">

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-orange text-white">Personal Details</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $staff->user->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $staff->user->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Photo</label>
                            <input type="file" name="photo" class="form-control">
                            @if(isset($staff->user->photo))
                                <img src="{{ asset('storage/' . $staff->user->photo) }}" alt="Staff Photo" class="img-thumbnail mt-2" style="max-width:100px;">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label>Contact (Phone)</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $staff->user->phone) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control" required>{{ old('address', $staff->user->address) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Emergency Contact Name</label>
                            <input type="text" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name', $staff->user->emergency_contact_name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Emergency Contact Phone</label>
                            <input type="text" name="emergency_contact_phone" class="form-control" value="{{ old('emergency_contact_phone', $staff->user->emergency_contact_phone) }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-orange text-white">Employment Details</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Role/Position</label>
                            <select name="designation" class="form-control" required>
                                <option value="chef" {{ $staff->designation == 'chef' ? 'selected' : '' }}>Chef</option>
                                <option value="waiter" {{ $staff->designation == 'waiter' ? 'selected' : '' }}>Waiter</option>
                                <option value="cashier" {{ $staff->designation == 'cashier' ? 'selected' : '' }}>Cashier</option>
                                <option value="manager" {{ $staff->designation == 'manager' ? 'selected' : '' }}>Manager</option>
                                <option value="delivery" {{ $staff->designation == 'delivery' ? 'selected' : '' }}>Delivery</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Salary</label>
                            <input type="number" name="salary" class="form-control" value="{{ old('salary', $staff->salary) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Shift</label>
                            <select name="shift" class="form-control" required>
                                <option value="morning" {{ $staff->shift == 'morning' ? 'selected' : '' }}>Morning</option>
                                <option value="evening" {{ $staff->shift == 'evening' ? 'selected' : '' }}>Evening</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Notes</label>
                            <textarea name="notes" class="form-control">{{ old('notes', $staff->notes ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Employment Status</label>
                            <select name="status" class="form-control" required>
                                <option value="active" {{ $staff->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="on leave" {{ $staff->status == 'on leave' ? 'selected' : '' }}>On Leave</option>
                                <option value="terminated" {{ $staff->status == 'terminated' ? 'selected' : '' }}>Terminated</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Joining Date</label>
                            <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date', $staff->joining_date) }}" required>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header bg-orange text-white">Work History</div>
                    <div class="card-body">
                        <p><strong>Orders handled:</strong> {{ $staff->orders()->count() }}</p>
                        <p><strong>Attendances:</strong> {{ $staff->attendances()->count() }}</p>
                        <p><strong>Leaves:</strong> {{ $staff->leaves()->count() }}</p>
                        <a href="#" class="btn btn-info btn-sm">View Full History</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end">
            <button class="btn btn-orange">Update Staff</button>
        </div>
    </form>
</div>

@endsection
