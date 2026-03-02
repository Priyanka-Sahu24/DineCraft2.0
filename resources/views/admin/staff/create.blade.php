@extends('admin.layouts.admin')
@section('title','Add Staff')
@section('content')

<div class="container mt-4">
    <h2 class="text-orange mb-3">Add New Staff</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.staff.store') }}" method="POST">
        @csrf
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Employee ID</label>
            <input type="text" name="employee_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Designation</label>
            <select name="designation" class="form-control" required>
                <option value="chef">Chef</option>
                <option value="waiter">Waiter</option>
                <option value="cashier">Cashier</option>
                <option value="manager">Manager</option>
                <option value="delivery">Delivery</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Salary</label>
            <input type="number" name="salary" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Joining Date</label>
            <input type="date" name="joining_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Shift</label>
            <select name="shift" class="form-control" required>
                <option value="morning">Morning</option>
                <option value="evening">Evening</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contact (Phone)</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Emergency Contact Name</label>
            <input type="text" name="emergency_contact_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Emergency Contact Phone</label>
            <input type="text" name="emergency_contact_phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role/Position</label>
            <select name="designation" class="form-control" required>
                <option value="chef">Chef</option>
                <option value="waiter">Waiter</option>
                <option value="cashier">Cashier</option>
                <option value="manager">Manager</option>
                <option value="delivery">Delivery</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Employment Status</label>
            <select name="status" class="form-control" required>
                <option value="active">Active</option>
                <option value="on leave">On Leave</option>
                <option value="terminated">Terminated</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Joining Date</label>
            <input type="date" name="joining_date" class="form-control" required>
        </div>
        <button class="btn btn-orange">Add Staff</button>
    </form>
</div>

@endsection
