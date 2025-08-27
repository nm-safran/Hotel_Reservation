@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center"
                        style="font-family: 'Inter', Arial, sans-serif; font-size: 2rem; letter-spacing: 0.03em;">
                        <img src="{{ asset('images/hotel-logo.png') }}" alt="Hotel Logo"
                            style="height:60px; margin-bottom:10px;">
                        <br>
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="card text-center shadow" style="border-radius: 1.5rem;">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <span class="btn btn-lg btn-gradient-primary rounded-circle shadow"
                                                style="font-size:2rem; pointer-events:none;">
                                                <i class="bi bi-calendar-check"></i>
                                            </span>
                                        </div>
                                        <h5 class="card-title"
                                            style="font-family: 'Inter', Arial, sans-serif; font-weight:700;">
                                            Total Reservations
                                        </h5>
                                        <p class="card-text display-6">{{ App\Models\Reservation::count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card text-center shadow" style="border-radius: 1.5rem;">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <span class="btn btn-lg btn-gradient-success rounded-circle shadow"
                                                style="font-size:2rem; pointer-events:none;">
                                                <i class="bi bi-people-fill"></i>
                                            </span>
                                        </div>
                                        <h5 class="card-title"
                                            style="font-family: 'Inter', Arial, sans-serif; font-weight:700;">
                                            Active Guests
                                        </h5>
                                        <p class="card-text display-6">
                                            {{ App\Models\Reservation::where('status', 'checked_in')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card text-center shadow" style="border-radius: 1.5rem;">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <span class="btn btn-lg btn-gradient-info rounded-circle shadow"
                                                style="font-size:2rem; pointer-events:none;">
                                                <i class="bi bi-door-open"></i>
                                            </span>
                                        </div>
                                        <h5 class="card-title"
                                            style="font-family: 'Inter', Arial, sans-serif; font-weight:700;">
                                            Available Rooms
                                        </h5>
                                        <p class="card-text display-6">
                                            {{ App\Models\Room::where('status', 'available')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card text-center shadow" style="border-radius: 1.5rem;">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <span class="btn btn-lg btn-gradient-warning rounded-circle shadow"
                                                style="font-size:2rem; pointer-events:none;">
                                                <i class="bi bi-cash-coin"></i>
                                            </span>
                                        </div>
                                        <h5 class="card-title"
                                            style="font-family: 'Inter', Arial, sans-serif; font-weight:700;">
                                            Pending Payments
                                        </h5>
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

@push('styles')
    <style>
        .btn-gradient-primary {
            background: linear-gradient(90deg, #6366f1, #f472b6);
            color: #fff;
            border: none;
        }

        .btn-gradient-success {
            background: linear-gradient(90deg, #22c55e, #38bdf8);
            color: #fff;
            border: none;
        }

        .btn-gradient-info {
            background: linear-gradient(90deg, #38bdf8, #6366f1);
            color: #fff;
            border: none;
        }

        .btn-gradient-warning {
            background: linear-gradient(90deg, #facc15, #f472b6);
            color: #fff;
            border: none;
        }
    </style>
@endpush
