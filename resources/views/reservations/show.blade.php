@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Reservation Details #{{ $reservation->id }}</h3>
                        <div>
                            @if ($reservation->status == 'confirmed')
                                <form action="{{ route('reservations.checkin', $reservation) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Check In</button>
                                </form>
                            @endif
                            @if ($reservation->status == 'checked_in')
                                <form action="{{ route('reservations.checkout', $reservation) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Check Out</button>
                                </form>
                            @endif
                            @if (in_array($reservation->status, ['confirmed', 'checked_in']))
                                <form action="{{ route('reservations.cancel', $reservation) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to cancel this reservation?')">Cancel</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Reservation Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Status</th>
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
                                    </tr>
                                    <tr>
                                        <th>Check-in Date</th>
                                        <td>{{ $reservation->check_in_date->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Check-out Date</th>
                                        <td>{{ $reservation->check_out_date->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Number of Nights</th>
                                        <td>{{ $reservation->nights }}</td>
                                    </tr>
                                    <tr>
                                        <th>Number of Guests</th>
                                        <td>{{ $reservation->number_of_guests }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount</th>
                                        <td>${{ number_format($reservation->total_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Special Requests</th>
                                        <td>{{ $reservation->special_requests ?? 'None' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5>Customer Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $reservation->customer->first_name }}
                                            {{ $reservation->customer->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $reservation->customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $reservation->customer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $reservation->customer->address }}</td>
                                    </tr>
                                </table>

                                <h5>Room Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Room Number</th>
                                        <td>{{ $reservation->room->room_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Room Type</th>
                                        <td>{{ ucfirst(str_replace('_', ' ', $reservation->room->room_type)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Capacity</th>
                                        <td>{{ $reservation->room->capacity }} guests</td>
                                    </tr>
                                    <tr>
                                        <th>Price per Night</th>
                                        <td>${{ number_format($reservation->room->price_per_night, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if ($reservation->status == 'checked_in')
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>Add Services</h5>
                                    <form action="{{ route('reservations.addService', $reservation) }}" method="POST"
                                        class="row g-3">
                                        @csrf
                                        <div class="col-md-4">
                                            <select name="service_id" class="form-select" required>
                                                <option value="">Select Service</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }} -
                                                        ${{ number_format($service->price, 2) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="quantity" class="form-control" placeholder="Qty"
                                                min="1" value="1" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="datetime-local" name="service_date" class="form-control"
                                                value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">Add Service</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>Services Used</h5>
                                    @if ($reservation->services->count() > 0)
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Service</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($reservation->services as $service)
                                                    <tr>
                                                        <td>{{ $service->service->name }}</td>
                                                        <td>{{ $service->quantity }}</td>
                                                        <td>${{ number_format($service->price, 2) }}</td>
                                                        <td>${{ number_format($service->price * $service->quantity, 2) }}
                                                        </td>
                                                        <td>{{ $service->service_date->format('M d, Y H:i') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>No services added yet.</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($reservation->billing)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>Billing Information</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Room Charges</th>
                                            <td>${{ number_format($reservation->billing->room_charges, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Service Charges</th>
                                            <td>${{ number_format($reservation->billing->service_charges, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tax Amount</th>
                                            <td>${{ number_format($reservation->billing->tax_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Amount</th>
                                            <td><strong>${{ number_format($reservation->billing->total_amount, 2) }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Payment Status</th>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $reservation->billing->payment_status == 'paid' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($reservation->billing->payment_status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
