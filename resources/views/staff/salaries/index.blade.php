@extends('staff.layout')

@section('content')


<div class="container mt-4">
    <div class="card shadow-lg mb-4 border-0">
        <div class="card-header bg-white d-flex align-items-center justify-content-between" style="border-bottom: 2px solid #fd7e14;">
            <h4 class="mb-0" style="background: #fd7e14; color: white; padding: 8px 16px; border-radius: 6px; display: inline-block; letter-spacing: 1px;">💰 My Salary Details</h4>
            <button class="btn btn-orange" disabled title="Download payslip (coming soon)"><i class="bi bi-download"></i> Download Payslip</button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Salary Summary Row -->
            <div class="row mb-4 text-center">
                <div class="col-md-3 mb-2">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <div class="fw-bold text-secondary">Total Months</div>
                        <div class="fs-4">{{ $salaries->count() }}</div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <div class="fw-bold text-secondary">Total Net Salary</div>
                        <div class="fs-4 text-success">₹ {{ number_format($salaries->sum('net_salary'),2) }}</div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <div class="fw-bold text-secondary">Paid Months</div>
                        <div class="fs-4 text-success">{{ $salaries->where('status','paid')->count() }}</div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <div class="fw-bold text-secondary">Unpaid Months</div>
                        <div class="fs-4 text-danger">{{ $salaries->where('status','unpaid')->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>Month</th>
                            <th>Basic</th>
                            <th>Bonus</th>
                            <th>Deduction</th>
                            <th>Net Salary</th>
                            <th>Status</th>
                            <th>Paid Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salaries as $salary)
                            <tr @if($salary->status=='unpaid') style="background:#fff3e0;" @endif>
                                <td>{{ $salary->month }} - {{ $salary->year }}</td>
                                <td>₹ {{ number_format($salary->basic_salary,2) }}</td>
                                <td>₹ {{ number_format($salary->bonus,2) }}</td>
                                <td>₹ {{ number_format($salary->deduction,2) }}</td>
                                <td><strong>₹ {{ number_format($salary->net_salary,2) }}</strong></td>
                                <td>
                                    @if($salary->status == 'paid')
                                        <span class="badge bg-success px-3 py-2">Paid</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2">Unpaid</span>
                                    @endif
                                </td>
                                <td>
                                    @if($salary->paid_date)
                                        {{ \Carbon\Carbon::parse($salary->paid_date)->format('d M Y') }}
                                    @else
                                        <span class="text-muted">Not Paid Yet</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No salary records available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection