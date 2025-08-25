@extends('layouts.app')

@section('content')
    <div class="hero-section mb-5">
        <div class="container">
            <h1 class="display-4">Welcome to Our Luxury Hotel</h1>
            <p class="lead">Experience unparalleled comfort and service</p>
            <a href="#availability" class="btn btn-light btn-lg">Check Availability</a>
        </div>
    </div>

    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center mb-0">Check Room Availability</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rooms.availability') }}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="check_in" class="form-label">Check-in Date</label>
                                        <input type="date" class="form-control" id="check_in" name="check_in" required
                                            min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="check_out" class="form-label">Check-out Date</label>
                                        <input type="date" class="form-control" id="check_out" name="check_out" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="guests" class="form-label">Guests</label>
                                        <input type="number" class="form-control" id="guests" name="guests"
                                            min="1" required value="1">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="room_type" class="form-label">Room Type</label>
                                        <select class="form-select" id="room_type" name="room_type">
                                            <option value="">Any</option>
                                            <option value="standard">Standard</option>
                                            <option value="deluxe">Deluxe</option>
                                            <option value="suite">Suite</option>
                                            <option value="residential_suite">Residential Suite</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Check Availability</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                        class="card-img-top" alt="Standard Room">
                    <div class="card-body">
                        <h5 class="card-title">Standard Rooms</h5>
                        <p class="card-text">Comfortable and affordable rooms with all essential amenities for a pleasant
                            stay.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                        class="card-img-top" alt="Deluxe Room">
                    <div class="card-body">
                        <h5 class="card-title">Deluxe Rooms</h5>
                        <p class="card-text">Spacious rooms with premium amenities and beautiful views for a luxurious
                            experience.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                        class="card-img-top" alt="Suite">
                    <div class="card-body">
                        <h5 class="card-title">Suites</h5>
                        <p class="card-text">Elegant suites with separate living areas, perfect for extended stays or
                            special occasions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum checkout date to tomorrow
            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');

            checkInInput.addEventListener('change', function() {
                const checkInDate = new Date(this.value);
                checkInDate.setDate(checkInDate.getDate() + 1);
                const nextDay = checkInDate.toISOString().split('T')[0];
                checkOutInput.min = nextDay;

                // If checkout date is before new checkin date, reset it
                if (checkOutInput.value && checkOutInput.value < nextDay) {
                    checkOutInput.value = nextDay;
                }
            });

            // Initialize checkout min date
            if (checkInInput.value) {
                const checkInDate = new Date(checkInInput.value);
                checkInDate.setDate(checkInDate.getDate() + 1);
                checkOutInput.min = checkInDate.toISOString().split('T')[0];
            } else {
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                checkOutInput.min = tomorrow.toISOString().split('T')[0];
            }
        });
    </script>
@endpush
