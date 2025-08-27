@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Financial Reports</h3>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>Revenue Summary</h5>
                                @php
                                    $totalRevenue = \App\Models\Billing::where('payment_status', 'paid')->sum(
                                        'total_amount',
                                    );
                                    $pendingRevenue = \App\Models\Billing::where('payment_status', 'pending')->sum(
                                        'total_amount',
                                    );
                                    $totalBills = \App\Models\Billing::count();
                                    $paidBills = \App\Models\Billing::where('payment_status', 'paid')->count();
                                    $pendingBills = \App\Models\Billing::where('payment_status', 'pending')->count();
                                @endphp

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bg-success text-white text-center mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Revenue</h5>
                                                <p class="card-text display-6">${{ number_format($totalRevenue, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card bg-warning text-white text-center mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Pending Revenue</h5>
                                                <p class="card-text display-6">${{ number_format($pendingRevenue, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card bg-info text-white text-center mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Bills</h5>
                                                <p class="card-text display-6">{{ $totalBills }}</p>
                                                <small>Paid: {{ $paidBills }} | Pending: {{ $pendingBills }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5>Daily Revenue (Last 30 Days)</h5>
                                @if ($revenueData->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Revenue</th>
                                                    <th>Number of Bills</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($revenueData as $data)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($data->date)->format('M d, Y') }}</td>
                                                        <td>${{ number_format($data->revenue, 2) }}</td>
                                                        <td>
                                                            @php
                                                                $billCount = \App\Models\Billing::whereDate(
                                                                    'created_at',
                                                                    $data->date,
                                                                )
                                                                    ->where('payment_status', 'paid')
                                                                    ->count();
                                                            @endphp
                                                            {{ $billCount }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>No revenue data available for the last 30 days.</p>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>Recent Payments</h5>
                                @php
                                    $recentPayments = \App\Models\Billing::with([
                                        'reservation.customer',
                                        'reservation.room',
                                    ])
                                        ->where('payment_status', 'paid')
                                        ->orderBy('created_at', 'desc')
                                        ->take(10)
                                        ->get();
                                @endphp

                                @if ($recentPayments->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Billing ID</th>
                                                    <th>Customer</th>
                                                    <th>Room</th>
                                                    <th>Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Paid Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recentPayments as $billing)
                                                    <tr>
                                                        <td>{{ $billing->id }}</td>
                                                        <td>{{ $billing->reservation->customer->first_name }}
                                                            {{ $billing->reservation->customer->last_name }}</td>
                                                        <td>{{ $billing->reservation->room->room_number }}</td>
                                                        <td>${{ number_format($billing->total_amount, 2) }}</td>
                                                        <td>{{ ucfirst($billing->payment_method) }}</td>
                                                        <td>{{ $billing->updated_at->format('M d, Y H:i') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>No recent payments found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
