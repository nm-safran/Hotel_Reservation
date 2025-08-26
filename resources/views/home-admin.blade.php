@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Admin Dashboard</div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <strong>Admin Privileges:</strong> You have full access to all system features.
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="card bg-primary text-white text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Reservations</h5>
                                        <p class="card-text display-6">{{ App\Models\Reservation::count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Add more admin-specific stats here -->
                        </div>

                        <div class="mt-4">
                            <h4>Quick Actions</h4>
                            <div class="d-grid gap-2 d-md-flex">
                                <a href="{{ route('rooms.index') }}" class="btn btn-primary me-md-2">Manage Rooms</a>
                                <a href="{{ route('reports.occupancy') }}" class="btn btn-info me-md-2">View Reports</a>
                                <a href="{{ route('reservations.index') }}" class="btn btn-success">View Reservations</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
