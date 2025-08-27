@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Generate Daily Report</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('reports.generateDaily') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="report_date" class="form-label">Select Date for Daily Report</label>
                                    <input type="date" class="form-control @error('report_date') is-invalid @enderror"
                                        id="report_date" name="report_date" value="{{ old('report_date', date('Y-m-d')) }}"
                                        required>
                                    @error('report_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <strong>Note:</strong> This report will:
                                <ul class="mb-0">
                                    <li>Generate no-show charges for reservations without credit cards</li>
                                    <li>Calculate occupancy rates</li>
                                    <li>Summarize daily revenue</li>
                                </ul>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Generate Report</button>
                                    <a href="{{ route('reports.occupancy') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
