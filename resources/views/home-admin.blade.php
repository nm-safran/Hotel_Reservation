@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"
                        style="font-family: 'Inter', Arial, sans-serif; font-size: 2rem; letter-spacing: 0.03em;">
                        <i class="bi bi-shield-lock me-2"></i>Admin Dashboard
                    </div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <strong>Admin Privileges:</strong> You have full access to all system features.
                        </div>

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
                                            style="font-family: 'Inter', Arial, sans-serif; font-weight:700;">Total
                                            Reservations</h5>
                                        <p class="card-text display-6">{{ App\Models\Reservation::count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Add more admin-specific stats here -->
                        </div>

                        <div class="mt-4">
                            <h4 style="font-family: 'Inter', Arial, sans-serif; font-weight:700;">Quick Actions</h4>
                            <div class="d-grid gap-2 d-md-flex">
                                <a href="{{ route('rooms.index') }}" class="btn btn-gradient-primary me-md-2">
                                    <i class="bi bi-door-open me-1"></i> Manage Rooms
                                </a>
                                <a href="{{ route('reports.occupancy') }}" class="btn btn-gradient-info me-md-2">
                                    <i class="bi bi-bar-chart-line me-1"></i> View Reports
                                </a>
                                <a href="{{ route('reservations.index') }}" class="btn btn-gradient-success">
                                    <i class="bi bi-list-ul me-1"></i> View Reservations
                                </a>
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
    </style>
@endpush
