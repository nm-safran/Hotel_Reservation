@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="card bg-primary text-white text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Reservations</h5>
                                        <p class="card-text display-6">{{ App\Models\Reservation::count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card bg-success text-white text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Active Guests</h5>
                                        <p class="card-text display-6">
                                            {{ App\Models\Reservation::where('status', 'checked_in')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card bg-info text-white text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Available Rooms</h5>
                                        <p class="card-text display-6">
                                            {{ App\Models\Room::where('status', 'available')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card bg-warning text-white text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Pending Payments</h5>
                                        <p class="card-text display-6">
                                            {{ App\Models\Billing::where('payment_status', 'pending')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">Recent Reservations</div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Customer</th>
                                                        <th>Room</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (App\Models\Reservation::with(['customer', 'room'])->latest()->take(5)->get() as $reservation)
                                                        <tr>
                                                            <td>{{ $reservation->id }}</td>
                                                            <td>{{ $reservation->customer->first_name }}
                                                                {{ $reservation->customer->last_name }}</td>
                                                            <td>{{ $reservation->room->room_number }}</td>
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
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">Upcoming Check-ins</div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Room</th>
                                                        <th>Check-in</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (App\Models\Reservation::with(['customer', 'room'])->where('status', 'confirmed')->whereDate('check_in_date', '>=', now())->orderBy('check_in_date')->take(5)->get() as $reservation)
                                                        <tr>
                                                            <td>{{ $reservation->customer->first_name }}
                                                                {{ $reservation->customer->last_name }}</td>
                                                            <td>{{ $reservation->room->room_number }}</td>
                                                            <td>{{ $reservation->check_in_date->format('M d, Y') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
