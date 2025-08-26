@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Reservation Clerk Dashboard</div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <strong>Clerk Privileges:</strong> You can manage reservations, customers, and billing.
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="card bg-primary text-white text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Today's Check-ins</h5>
                                        <p class="card-text display-6">
                                            {{ App\Models\Reservation::whereDate('check_in_date', today())->where('status', 'confirmed')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Add more clerk-specific stats here -->
                        </div>

                        <div class="mt-4">
                            <h4>Quick Actions</h4>
                            <div class="d-grid gap-2 d-md-flex">
                                <a href="{{ route('reservations.create') }}" class="btn btn-primary me-md-2">New
                                    Reservation</a>
                                <a href="{{ route('customers.create') }}" class="btn btn-success me-md-2">New Customer</a>
                                <a href="{{ route('reservations.index') }}" class="btn btn-info">View Reservations</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
