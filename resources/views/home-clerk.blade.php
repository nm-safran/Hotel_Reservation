@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"
                        style="font-family: 'Inter', Arial, sans-serif; font-size: 2rem; letter-spacing: 0.03em;">
                        <i class="bi bi-person-badge me-2"></i>Reservation Clerk Dashboard
                    </div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <strong>Clerk Privileges:</strong> You can manage reservations, customers, and billing.
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
                                            style="font-family: 'Inter', Arial, sans-serif; font-weight:700;">Today's
                                            Check-ins</h5>
                                        <p class="card-text display-6">
                                            {{ App\Models\Reservation::whereDate('check_in_date', today())->where('status', 'confirmed')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Add more clerk-specific stats here -->
                        </div>

                        <div class="mt-4">
                            <h4 style="font-family: 'Inter', Arial, sans-serif; font-weight:700;">Quick Actions</h4>
                            <div class="d-grid gap-2 d-md-flex">
                                <a href="{{ route('reservations.create') }}" class="btn btn-gradient-primary me-md-2">
                                    <i class="bi bi-plus-circle me-1"></i> New Reservation
                                </a>
                                <a href="{{ route('customers.create') }}" class="btn btn-gradient-success me-md-2">
                                    <i class="bi bi-person-plus me-1"></i> New Customer
                                </a>
                                <a href="{{ route('reservations.index') }}" class="btn btn-gradient-info">
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
