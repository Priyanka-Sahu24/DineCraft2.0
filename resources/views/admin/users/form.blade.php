@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role" required>
            <option value="">Select Role</option>
            <option value="admin" {{ (old('role', isset($user) && $user->roles->first() ? $user->roles->first()->name : '') == 'admin') ? 'selected' : '' }}>Admin</option>
            <option value="staff" {{ (old('role', isset($user) && $user->roles->first() ? $user->roles->first()->name : '') == 'staff') ? 'selected' : '' }}>Staff</option>
            <option value="customer" {{ (old('role', isset($user) && $user->roles->first() ? $user->roles->first()->name : '') == 'customer') ? 'selected' : '' }}>Customer</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="password" class="form-label">Password @if(!isset($user))<span class="text-muted">(required)</span>@endif</label>
        <input type="password" class="form-control" id="password" name="password" @if(!isset($user)) required @endif>
    </div>
</div>