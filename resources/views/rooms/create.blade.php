@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Add New Room</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('rooms.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="room_number" class="form-label">Room Number *</label>
                                    <input type="text" class="form-control @error('room_number') is-invalid @enderror"
                                        id="room_number" name="room_number" value="{{ old('room_number') }}" required>
                                    @error('room_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="room_type" class="form-label">Room Type *</label>
                                    <select class="form-select @error('room_type') is-invalid @enderror" id="room_type"
                                        name="room_type" required>
                                        <option value="">Select Room Type</option>
                                        <option value="standard" {{ old('room_type') == 'standard' ? 'selected' : '' }}>
                                            Standard</option>
                                        <option value="deluxe" {{ old('room_type') == 'deluxe' ? 'selected' : '' }}>Deluxe
                                        </option>
                                        <option value="suite" {{ old('room_type') == 'suite' ? 'selected' : '' }}>Suite
                                        </option>
                                        <option value="residential_suite"
                                            {{ old('room_type') == 'residential_suite' ? 'selected' : '' }}>Residential
                                            Suite</option>
                                    </select>
                                    @error('room_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="capacity" class="form-label">Capacity *</label>
                                    <input type="number" class="form-control @error('capacity') is-invalid @enderror"
                                        id="capacity" name="capacity" value="{{ old('capacity', 2) }}" min="1"
                                        required>
                                    @error('capacity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="price_per_night" class="form-label">Price per Night ($) *</label>
                                    <input type="number"
                                        class="form-control @error('price_per_night') is-invalid @enderror"
                                        id="price_per_night" name="price_per_night" value="{{ old('price_per_night') }}"
                                        min="0" step="0.01" required>
                                    @error('price_per_night')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="weekly_rate" class="form-label">Weekly Rate ($)</label>
                                    <input type="number" class="form-control @error('weekly_rate') is-invalid @enderror"
                                        id="weekly_rate" name="weekly_rate" value="{{ old('weekly_rate') }}" min="0"
                                        step="0.01">
                                    @error('weekly_rate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="monthly_rate" class="form-label">Monthly Rate ($)</label>
                                    <input type="number" class="form-control @error('monthly_rate') is-invalid @enderror"
                                        id="monthly_rate" name="monthly_rate" value="{{ old('monthly_rate') }}"
                                        min="0" step="0.01">
                                    @error('monthly_rate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="amenities" class="form-label">Amenities</label>
                                    <textarea class="form-control @error('amenities') is-invalid @enderror" id="amenities" name="amenities" rows="3"
                                        placeholder="Enter amenities, one per line">{{ old('amenities') }}</textarea>
                                    @error('amenities')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Create Room</button>
                                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
