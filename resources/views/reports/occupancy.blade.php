@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Occupancy Reports</h3>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>Current Room Status</h5>
                                <div class="row">
                                    @php
                                        $availableRooms = $rooms->where('status', 'available')->count();
                                        $occupiedRooms = $rooms->where('status', 'occupied')->count();
                                        $maintenanceRooms = $rooms->where('status', 'maintenance')->count();
                                        $totalRooms = $rooms->count();
                                        $occupancyRate = $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0;
                                    @endphp

                                    <div class="col-md-4">
                                        <div class="card bg-success text-white text-center mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Available</h5>
                                                <p class="card-text display-6">{{ $availableRooms }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card bg-danger text-white text-center mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Occupied</h5>
                                                <p class="card-text display-6">{{ $occupiedRooms }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card bg-warning text-white text-center mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Maintenance</h5>
                                                <p class="card-text display-6">{{ $maintenanceRooms }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <strong>Occupancy Rate: {{ number_format($occupancyRate, 2) }}%</strong>
                                    ({{ $occupiedRooms }} of {{ $totalRooms }} rooms occupied)
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5>Room Details</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Room Number</th>
                                                <th>Type</th>
                                                <th>Capacity</th>
                                                <th>Status</th>
                                                <th>Current Reservation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rooms as $room)
                                                @php
                                                    $currentReservation = $room
                                                        ->reservations()
                                                        ->whereIn('status', ['confirmed', 'checked_in'])
                                                        ->where('check_in_date', '<=', now())
                                                        ->where('check_out_date', '>=', now())
                                                        ->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ $room->room_number }}</td>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $room->room_type)) }}</td>
                                                    <td>{{ $room->capacity }} guests</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'danger' : 'warning') }}">
                                                            {{ ucfirst($room->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($currentReservation)
                                                            <a
                                                                href="{{ route('reservations.show', $currentReservation) }}">
                                                                #{{ $currentReservation->id }} -
                                                                {{ $currentReservation->customer->first_name }}
                                                                {{ $currentReservation->customer->last_name }}
                                                            </a>
                                                            <br>
                                                            <small>
                                                                {{ $currentReservation->check_in_date->format('M d') }} -
                                                                {{ $currentReservation->check_out_date->format('M d') }}
                                                            </small>
                                                        @else
                                                            <span class="text-muted">No current reservation</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>Upcoming Check-ins (Next 7 Days)</h5>
                                @php
                                    $upcomingCheckins = \App\Models\Reservation::with(['customer', 'room'])
                                        ->where('status', 'confirmed')
                                        ->whereBetween('check_in_date', [now(), now()->addDays(7)])
                                        ->orderBy('check_in_date')
                                        ->get();
                                @endphp

                                @if ($upcomingCheckins->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Reservation ID</th>
                                                    <th>Customer</th>
                                                    <th>Room</th>
                                                    <th>Check-in Date</th>
                                                    <th>Nights</th>
                                                    <th>Guests</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($upcomingCheckins as $reservation)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('reservations.show', $reservation) }}">
                                                                #{{ $reservation->id }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $reservation->customer->first_name }}
                                                            {{ $reservation->customer->last_name }}</td>
                                                        <td>{{ $reservation->room->room_number }}</td>
                                                        <td>{{ $reservation->check_in_date->format('M d, Y') }}</td>
                                                        <td>{{ $reservation->nights }}</td>
                                                        <td>{{ $reservation->number_of_guests }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>No upcoming check-ins in the next 7 days.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
