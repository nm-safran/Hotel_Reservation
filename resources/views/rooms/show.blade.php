@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Room Details: {{ $room->room_number }}</h3>
                        <div>
                            <a href="{{ route('rooms.edit', $room) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Room Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Room Number</th>
                                        <td>{{ $room->room_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Room Type</th>
                                        <td>{{ ucfirst(str_replace('_', ' ', $room->room_type)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Capacity</th>
                                        <td>{{ $room->capacity }} guests</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span
                                                class="badge bg-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($room->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Price per Night</th>
                                        <td>${{ number_format($room->price_per_night, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Weekly Rate</th>
                                        <td>${{ number_format($room->weekly_rate, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Monthly Rate</th>
                                        <td>${{ number_format($room->monthly_rate, 2) }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5>Amenities</h5>
                                @if ($room->amenities)
                                    <div class="amenities-list">
                                        {!! nl2br(e($room->amenities)) !!}
                                    </div>
                                @else
                                    <p>No amenities specified.</p>
                                @endif

                                <h5 class="mt-4">Reservation Statistics</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Total Reservations</th>
                                        <td>{{ $room->reservations->count() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Active Reservations</th>
                                        <td>{{ $room->reservations->whereIn('status', ['confirmed', 'checked_in'])->count() }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Completed Reservations</th>
                                        <td>{{ $room->reservations->where('status', 'checked_out')->count() }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if ($room->reservations->count() > 0)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>Recent Reservations</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Reservation ID</th>
                                                    <th>Customer</th>
                                                    <th>Check-in</th>
                                                    <th>Check-out</th>
                                                    <th>Status</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($room->reservations->sortByDesc('created_at')->take(5) as $reservation)
                                                    <tr>
                                                        <td>
                                                            <a
                                                                href="{{ route('reservations.show', $reservation) }}">#{{ $reservation->id }}</a>
                                                        </td>
                                                        <td>{{ $reservation->customer->first_name }}
                                                            {{ $reservation->customer->last_name }}</td>
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
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
