@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Customer Details: {{ $customer->first_name }} {{ $customer->last_name }}</h3>
                        <div>
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('reservations.create') }}?customer_id={{ $customer->id }}"
                                class="btn btn-primary btn-sm">New Reservation</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Personal Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $customer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $customer->address }}</td>
                                    </tr>
                                    @if ($customer->id_type && $customer->id_number)
                                        <tr>
                                            <th>ID Type</th>
                                            <td>{{ $customer->id_type }}</td>
                                        </tr>
                                        <tr>
                                            <th>ID Number</th>
                                            <td>{{ $customer->id_number }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Customer Type</th>
                                        <td>
                                            @if ($customer->is_company)
                                                <span class="badge bg-info">Company</span>
                                                @if ($customer->company_name)
                                                    <br>{{ $customer->company_name }}
                                                @endif
                                                @if ($customer->discount_rate > 0)
                                                    <br><small>Discount: {{ $customer->discount_rate }}%</small>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Individual</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5>Reservation History</h5>
                                @if ($customer->reservations->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Reservation ID</th>
                                                    <th>Room</th>
                                                    <th>Check-in</th>
                                                    <th>Check-out</th>
                                                    <th>Status</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer->reservations as $reservation)
                                                    <tr>
                                                        <td>
                                                            <a
                                                                href="{{ route('reservations.show', $reservation) }}">#{{ $reservation->id }}</a>
                                                        </td>
                                                        <td>{{ $reservation->room->room_number }}</td>
                                                        <td>{{ $reservation->check_in_date->format('M d, Y') }}</td>
                                                        <td>{{ $reservation->check_out_date->format('M d, Y') }}</td>
                                                        <td>
                                                            <span
                                                                class="badge bg-{{ $reservation->status == 'confirmed'
                                                                    ? 'info'
                                                                    : ($reservation->status == 'checked_in'
                                                                        ? 'success'
                                                                        : ($reservation->status == 'checked_out'
                                                                            ? 'secondary'
                                                                            : ($reservation->status == 'cancelled'
                                                                                ? 'danger'
                                                                                : 'warning'))) }}">
                                                                {{ ucfirst($reservation->status) }}
                                                            </span>
                                                        </td>
                                                        <td>${{ number_format($reservation->total_amount, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>No reservations found for this customer.</p>
                                @endif

                                <h5 class="mt-4">Billing Summary</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Total Reservations</th>
                                        <td>{{ $customer->reservations->count() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount</th>
                                        <td>${{ number_format($customer->reservations->sum('total_amount'), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Active Reservations</th>
                                        <td>
                                            {{ $customer->reservations->whereIn('status', ['confirmed', 'checked_in'])->count() }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
