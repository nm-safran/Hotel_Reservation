@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Edit Reservation #{{ $reservation->id }}</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('reservations.update', $reservation) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="check_out_date" class="form-label">Check-out Date</label>
                                    <input type="date" class="form-control @error('check_out_date') is-invalid @enderror"
                                        id="check_out_date" name="check_out_date"
                                        value="{{ old('check_out_date', $reservation->check_out_date->format('Y-m-d')) }}"
                                        required>
                                    @error('check_out_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-8">
                                    <label for="special_requests" class="form-label">Special Requests</label>
                                    <textarea class="form-control @error('special_requests') is-invalid @enderror" id="special_requests"
                                        name="special_requests" rows="2">{{ old('special_requests', $reservation->special_requests) }}</textarea>
                                    @error('special_requests')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Update Reservation</button>
                                    <a href="{{ route('reservations.show', $reservation) }}"
                                        class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Set minimum checkout date to day after check-in
                const checkInDate = new Date('{{ $reservation->check_in_date->format('Y-m-d') }}');
                checkInDate.setDate(checkInDate.getDate() + 1);
                const minCheckOutDate = checkInDate.toISOString().split('T')[0];

                document.getElementById('check_out_date').min = minCheckOutDate;
            });
        </script>
    @endpush
@endsection
