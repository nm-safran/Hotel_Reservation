@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Create New Customer</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('customers.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name *</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                        id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone *</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="address" class="form-label">Address *</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2"
                                        required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="id_type" class="form-label">ID Type</label>
                                    <select class="form-select @error('id_type') is-invalid @enderror" id="id_type"
                                        name="id_type">
                                        <option value="">Select ID Type</option>
                                        <option value="passport" {{ old('id_type') == 'passport' ? 'selected' : '' }}>
                                            Passport</option>
                                        <option value="driver_license"
                                            {{ old('id_type') == 'driver_license' ? 'selected' : '' }}>Driver's License
                                        </option>
                                        <option value="national_id"
                                            {{ old('id_type') == 'national_id' ? 'selected' : '' }}>National ID</option>
                                        <option value="other" {{ old('id_type') == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('id_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="id_number" class="form-label">ID Number</label>
                                    <input type="text" class="form-control @error('id_number') is-invalid @enderror"
                                        id="id_number" name="id_number" value="{{ old('id_number') }}">
                                    @error('id_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <div class="form-check mt-4 pt-2">
                                        <input class="form-check-input" type="checkbox" name="is_company" id="is_company"
                                            value="1" {{ old('is_company') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_company">
                                            This is a company/organization
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 company-fields" style="display: none;">
                                <div class="col-md-6">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                        id="company_name" name="company_name" value="{{ old('company_name') }}">
                                    @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="discount_rate" class="form-label">Discount Rate (%)</label>
                                    <input type="number"
                                        class="form-control @error('discount_rate') is-invalid @enderror"
                                        id="discount_rate" name="discount_rate" value="{{ old('discount_rate', 0) }}"
                                        min="0" max="100" step="0.01">
                                    @error('discount_rate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Create Customer</button>
                                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
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
            // Show/hide company fields based on checkbox
            const companyCheckbox = document.getElementById('is_company');
            const companyFields = document.querySelector('.company-fields');

            function toggleCompanyFields() {
                companyFields.style.display = companyCheckbox.checked ? 'block' : 'none';
            }

            companyCheckbox.addEventListener('change', toggleCompanyFields);
            toggleCompanyFields(); // Initial state
        });
    </script>
@endpush
