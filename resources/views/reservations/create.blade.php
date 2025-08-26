@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Create New Reservation</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('reservations.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5>Customer Information</h5>
                                    <select name="customer_id"
                                        class="form-select @error('customer_id') is-invalid @enderror" required>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->first_name }} {{ $customer->last_name }} -
                                                {{ $customer->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <h5>Room Information</h5>
                                    <select name="room_id" class="form-select @error('room_id') is-invalid @enderror"
                                        required>
                                        <option value="">Select Room</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}"
                                                {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                {{ $room->room_number }} - {{ ucfirst($room->room_type) }}
                                                (${{ number_format($room->price_per_night, 2) }}/night)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('room_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="check_in_date" class="form-label">Check-in Date</label>
                                    <input type="date" class="form-control @error('check_in_date') is-invalid @enderror"
                                        id="check_in_date" name="check_in_date"
                                        value="{{ old('check_in_date', $checkIn ?? '') }}" required>
                                    @error('check_in_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="check_out_date" class="form-label">Check-out Date</label>
                                    <input type="date" class="form-control @error('check_out_date') is-invalid @enderror"
                                        id="check_out_date" name="check_out_date"
                                        value="{{ old('check_out_date', $checkOut ?? '') }}" required>
                                    @error('check_out_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label for="number_of_guests" class="form-label">Number of Guests</label>
                                    <input type="number"
                                        class="form-control @error('number_of_guests') is-invalid @enderror"
                                        id="number_of_guests" name="number_of_guests"
                                        value="{{ old('number_of_guests', $guests ?? 1) }}" min="1" required>
                                    @error('number_of_guests')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="special_requests" class="form-label">Special Requests</label>
                                    <textarea class="form-control @error('special_requests') is-invalid @enderror" id="special_requests"
                                        name="special_requests" rows="1">{{ old('special_requests') }}</textarea>
                                    @error('special_requests')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_block_booking"
                                            id="is_block_booking" value="1"
                                            {{ old('is_block_booking') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_block_booking">
                                            This is a block booking (for travel companies)
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3 number-of-rooms" style="display: none;">
                                    <label for="number_of_rooms" class="form-label">Number of Rooms</label>
                                    <input type="number"
                                        class="form-control @error('number_of_rooms') is-invalid @enderror"
                                        id="number_of_rooms" name="number_of_rooms" value="{{ old('number_of_rooms', 1) }}"
                                        min="1">
                                    @error('number_of_rooms')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h5>Payment Information (Optional)</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="credit_card_name" class="form-label">Name on Card</label>
                                            <input type="text"
                                                class="form-control @error('credit_card_name') is-invalid @enderror"
                                                id="credit_card_name" name="credit_card_name"
                                                value="{{ old('credit_card_name') }}">
                                            @error('credit_card_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="credit_card_number" class="form-label">Card Number</label>
                                            <input type="text"
                                                class="form-control @error('credit_card_number') is-invalid @enderror"
                                                id="credit_card_number" name="credit_card_number"
                                                value="{{ old('credit_card_number') }}">
                                            @error('credit_card_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="credit_card_expiry" class="form-label">Expiry Date</label>
                                            <input type="text"
                                                class="form-control @error('credit_card_expiry') is-invalid @enderror"
                                                id="credit_card_expiry" name="credit_card_expiry"
                                                value="{{ old('credit_card_expiry') }}" placeholder="MM/YY">
                                            @error('credit_card_expiry')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Create Reservation</button>
                                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show/hide number of rooms field based on block booking checkbox
            const blockBookingCheckbox = document.getElementById('is_block_booking');
            const numberOfRoomsField = document.querySelector('.number-of-rooms');

            function toggleNumberOfRoomsField() {
                numberOfRoomsField.style.display = blockBookingCheckbox.checked ? 'block' : 'none';
            }

            blockBookingCheckbox.addEventListener('change', toggleNumberOfRoomsField);
            toggleNumberOfRoomsField(); // Initial state

            // Set minimum dates
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('check_in_date').min = today;

            const checkInInput = document.getElementById('check_in_date');
            const checkOutInput = document.getElementById('check_out_date');

            checkInInput.addEventListener('change', function() {
                const checkInDate = new Date(this.value);
                checkInDate.setDate(checkInDate.getDate() + 1);
                const nextDay = checkInDate.toISOString().split('T')[0];
                checkOutInput.min = nextDay;

                if (checkOutInput.value && checkOutInput.value < nextDay) {
                    checkOutInput.value = nextDay;
                }
            });
        });
    </script>
@endpush
