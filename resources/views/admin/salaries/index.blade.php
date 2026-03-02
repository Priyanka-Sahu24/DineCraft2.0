@extends('admin.layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg mb-4">
        <div class="card-header bg-orange text-white">
            <h4 class="mb-0" style="color: #fd7e14;">💰 Salary Management</h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Filter Form -->
            <form method="GET" class="row mb-3">
                <div class="col-md-3 mb-2">
                    <input type="text" name="search_name" class="form-control" placeholder="Search by Employee Name" value="{{ request('search_name') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <select name="filter_staff" class="form-select">
                        <option value="">All Staff</option>
                        @foreach($staff as $s)
                            <option value="{{ $s->id }}" {{ request('filter_staff') == $s->id ? 'selected' : '' }}>{{ $s->user->name ?? 'No Name' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <select name="filter_month" class="form-select">
                        <option value="">All Months</option>
                        @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                            <option value="{{ $m }}" {{ request('filter_month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <select name="filter_year" class="form-select">
                        <option value="">All Years</option>
                        @for($y = date('Y')-2; $y <= date('Y')+2; $y++)
                            <option value="{{ $y }}" {{ request('filter_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <button class="btn btn-orange w-100">Search</button>
                </div>
            </form>

            <!-- Add Salary Form -->
            <form action="{{ route('admin.salaries.store') }}" method="POST" id="salaryForm">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Select Staff</label>
                        <select name="staff_id" class="form-select" required>
                        @foreach($staff as $s)
                           <option value="{{ $s->id }}">
                                {{ $s->user->name ?? 'No Name' }} ({{ ucfirst($s->designation) }})
                              </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Basic Salary</label>
                        <input type="number" name="basic_salary" id="basic_salary" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">HRA</label>
                        <input type="number" name="hra" id="hra" class="form-control" value="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">DA</label>
                        <input type="number" name="da" id="da" class="form-control" value="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">TA</label>
                        <input type="number" name="ta" id="ta" class="form-control" value="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Medical Allowance</label>
                        <input type="number" name="medical" id="medical" class="form-control" value="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Other Allowances</label>
                        <input type="number" name="other_allowances" id="other_allowances" class="form-control" value="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Overtime Pay</label>
                        <input type="number" name="overtime" id="overtime" class="form-control" value="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Gross Salary</label>
                        <input type="number" name="gross_salary" id="gross_salary" class="form-control" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tax</label>
                        <input type="number" name="tax" id="tax" class="form-control" value="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Provident Fund</label>
                        <input type="number" name="provident_fund" id="provident_fund" class="form-control" value="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Penalties</label>
                        <input type="number" name="penalties" id="penalties" class="form-control" value="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Total Deductions</label>
                        <input type="number" name="deduction" id="deduction" class="form-control" value="0" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Net Salary</label>
                        <input type="number" name="net_salary" id="net_salary" class="form-control" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-select" required>
                            @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Year</label>
                        <select name="year" class="form-select" required>
                            @for($y = date('Y')-2; $y <= date('Y')+2; $y++)
                                <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    ➕ Add Salary
                </button>
            </form>

            <script>
            function calculateSalary() {
                let basic = parseFloat(document.getElementById('basic_salary').value) || 0;
                let hra = parseFloat(document.getElementById('hra').value) || 0;
                let da = parseFloat(document.getElementById('da').value) || 0;
                let ta = parseFloat(document.getElementById('ta').value) || 0;
                let medical = parseFloat(document.getElementById('medical').value) || 0;
                let other = parseFloat(document.getElementById('other_allowances').value) || 0;
                let overtime = parseFloat(document.getElementById('overtime').value) || 0;
                let tax = parseFloat(document.getElementById('tax').value) || 0;
                let pf = parseFloat(document.getElementById('provident_fund').value) || 0;
                let penalties = parseFloat(document.getElementById('penalties').value) || 0;

                let deduction = tax + pf + penalties;
                document.getElementById('deduction').value = deduction.toFixed(2);

                let gross = basic + hra + da + ta + medical + other + overtime;
                let net = gross - deduction;
                document.getElementById('gross_salary').value = gross.toFixed(2);
                document.getElementById('net_salary').value = net.toFixed(2);
            }
            document.querySelectorAll('#salaryForm input').forEach(function(input) {
                input.addEventListener('input', calculateSalary);
            });
            </script>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-orange text-white">
            <h5 class="mb-0" style="color: #fd7e14;">Salary Records</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Staff</th>
                        <th>Role</th>
                        <th>Month</th>
                        <th>Basic</th>
                        <th>HRA</th>
                        <th>DA</th>
                        <th>TA</th>
                        <th>Medical</th>
                        <th>Other Allowances</th>
                        <th>Overtime</th>
                        <th>Gross Salary</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                        <th>Status</th>
                        <th>Paid Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salaries as $salary)
                    <tr>
                        <td>{{ $salary->staff->user->name ?? '' }}</td>
                        <td>{{ ucfirst($salary->staff->designation ?? '') }}</td>
                        <td>{{ $salary->month }} - {{ $salary->year }}</td>
                        <td>₹ {{ number_format($salary->basic_salary,2) }}</td>
                        <td>₹ {{ number_format($salary->hra ?? 0,2) }}</td>
                        <td>₹ {{ number_format($salary->da ?? 0,2) }}</td>
                        <td>₹ {{ number_format($salary->ta ?? 0,2) }}</td>
                        <td>₹ {{ number_format($salary->medical ?? 0,2) }}</td>
                        <td>₹ {{ number_format($salary->other_allowances ?? 0,2) }}</td>
                        <td>₹ {{ number_format($salary->overtime ?? 0,2) }}</td>
                        <td>₹ {{ number_format($salary->gross_salary ?? 0,2) }}</td>
                        <td>₹ {{ number_format($salary->deduction ?? 0,2) }}</td>
                        <td>₹ {{ number_format($salary->net_salary ?? 0,2) }}</td>
                        <td>
                            @if($salary->status == 'paid')
                                <span class="badge bg-success px-3 py-2">Paid</span>
                            @else
                                <span class="badge bg-danger px-3 py-2">Unpaid</span>
                            @endif
                        </td>
                        <td>
                            @if($salary->status == 'paid')
                                {{ $salary->paid_date ? date('d M Y', strtotime($salary->paid_date)) : '-' }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($salary->status == 'unpaid')
                                <a href="{{ route('admin.salaries.paid',$salary->id) }}" class="btn btn-sm btn-success mb-1">✔ Mark Paid</a>
                                <a href="{{ route('admin.salaries.edit',$salary->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                <form action="{{ route('admin.salaries.destroy',$salary->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger mb-1" onclick="return confirm('Delete this salary record?')">Delete</button>
                                </form>
                            @else
                                <span class="text-muted">Completed</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @if($salaries->count() == 0)
                        <tr>
                            <td colspan="10">No salary records found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection