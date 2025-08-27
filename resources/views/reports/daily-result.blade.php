@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Daily Report for {{ $date->format('F j, Y') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>Summary</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card bg-primary text-white text-center mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Occupied Rooms</h5>
                                                <p class="card-text display-6">{{ $occupiedRooms }}</p>
                                                <small>of {{ $totalRooms }} total</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card bg-success text-white text-center mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Occupancy Rate</h5>
                                                <p class="card-text display-6">{{ number_format($occupancyRate, 1) }}%</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card bg-info text-white text-center mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Revenue</h5>
                                                <p class="card-text display-6">${{ number_format($revenue, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card bg-warning text-white text-center mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Pending Revenue</h5>
                                                <p class="card-text display-6">${{ number_format($pendingRevenue, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>No-show Reservations</h5>
                                @if ($noShows->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Reservation ID</th>
                                                    <th>Customer</th>
                                                    <th>Room</th>
                                                    <th>Charged Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($noShows as $reservation)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('reservations.show', $reservation) }}">
                                                                #{{ $reservation->id }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $reservation->customer->first_name }}
                                                            {{ $reservation->customer->last_name }}</td>
                                                        <td>{{ $reservation->room->room_number }}</td>
                                                        <td>${{ number_format($reservation->total_amount, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>No no-show reservations for this date.</p>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <h5>Revenue Breakdown</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Total Collected Revenue</th>
                                        <td class="text-end">${{ number_format($revenue, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pending Revenue</th>
                                        <td class="text-end">${{ number_format($pendingRevenue, 2) }}</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <th><strong>Total Revenue</strong></th>
                                        <td class="text-end">
                                            <strong>${{ number_format($revenue + $pendingRevenue, 2) }}</strong></td>
                                    </tr>
                                </table>

                                <h5 class="mt-4">Occupancy Details</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Total Rooms</th>
                                        <td class="text-end">{{ $totalRooms }}</td>
                                    </tr>
                                    <tr>
                                        <th>Occupied Rooms</th>
                                        <td class="text-end">{{ $occupiedRooms }}</td>
                                    </tr>
                                    <tr>
                                        <th>Vacant Rooms</th>
                                        <td class="text-end">{{ $totalRooms - $occupiedRooms }}</td>
                                    </tr>
                                    <tr>
                                        <th>Occupancy Rate</th>
                                        <td class="text-end">{{ number_format($occupancyRate, 2) }}%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-grid gap-2 d-md-flex">
                                    <a href="{{ route('reports.daily') }}" class="btn btn-primary me-md-2">Generate Another
                                        Report</a>
                                    <a href="{{ route('reports.occupancy') }}" class="btn btn-secondary">Back to
                                        Reports</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
