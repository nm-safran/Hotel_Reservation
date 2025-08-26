@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Reservations</h3>
                        <a href="{{ route('reservations.create') }}" class="btn btn-primary">New Reservation</a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Room</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Guests</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation->id }}</td>
                                            <td>{{ $reservation->customer->first_name }}
                                                {{ $reservation->customer->last_name }}</td>
                                            <td>{{ $reservation->room->room_number }} ({{ $reservation->room->room_type }})
                                            </td>
                                            <td>{{ $reservation->check_in_date->format('M d, Y') }}</td>
                                            <td>{{ $reservation->check_out_date->format('M d, Y') }}</td>
                                            <td>{{ $reservation->number_of_guests }}</td>
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
                                            <td>
                                                <a href="{{ route('reservations.show', $reservation) }}"
                                                    class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('reservations.edit', $reservation) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No reservations found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($reservations->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $reservations->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
