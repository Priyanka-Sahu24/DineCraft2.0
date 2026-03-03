@extends('admin.layouts.admin')
@section('content')
<div class="container">
    <h1 class="payments-header">Payments & Revenue</h1>
    <div class="card mb-4 payments-card">
        <div class="card-body">
            <h4 class="payments-total">Total Revenue: ₹{{ number_format($totalRevenue, 2) }}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4 payments-card">
                <div class="card-header payments-section-title">Customer Payments</div>
                <div class="card-body">
                    <table class="table table-bordered payments-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->order && $payment->order->user ? $payment->order->user->name : 'N/A' }}</td>
                                <td>₹{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 payments-card">
                <div class="card-header payments-section-title">Staff Salaries (Deducted)</div>
                <div class="card-body">
                    <table class="table table-bordered payments-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Staff</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salaries as $salary)
                            <tr>
                                <td>{{ $salary->id }}</td>
                                <td>
                                    @if(isset($salary->staff->user) && isset($salary->staff->user->name))
                                        {{ $salary->staff->user->name }}
                                    @elseif(isset($salary->staff->name))
                                        {{ $salary->staff->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>-₹{{ number_format($salary->net_salary, 2) }}</td>
                                <td>{{ $salary->created_at->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
