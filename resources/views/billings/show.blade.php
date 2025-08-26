@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Billing Details #{{ $billing->id }}</h3>
                        <div>
                            @if ($billing->payment_status == 'pending')
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#paymentModal">
                                    Process Payment
                                </button>
                            @endif
                            <a href="{{ route('reservations.show', $billing->reservation) }}"
                                class="btn btn-info btn-sm">View Reservation</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Billing Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Billing ID</th>
                                        <td>{{ $billing->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Reservation ID</th>
                                        <td>
                                            <a href="{{ route('reservations.show', $billing->reservation) }}">
                                                #{{ $billing->reservation_id }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status</th>
                                        <td>
                                            <span
                                                class="badge bg-{{ $billing->payment_status == 'paid' ? 'success' : ($billing->payment_status == 'pending' ? 'warning' : 'info') }}">
                                                {{ ucfirst($billing->payment_status) }}
                                            </span>
                                            @if ($billing->is_no_show_charge)
                                                <br><small class="text-danger">No-show charge</small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method</th>
                                        <td>{{ ucfirst($billing->payment_method) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $billing->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    @if ($billing->payment_details)
                                        <tr>
                                            <th>Payment Details</th>
                                            <td>{{ $billing->payment_details }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5>Charge Breakdown</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Room Charges</th>
                                        <td class="text-end">${{ number_format($billing->room_charges, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Service Charges</th>
                                        <td class="text-end">${{ number_format($billing->service_charges, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tax Amount (10%)</th>
                                        <td class="text-end">${{ number_format($billing->tax_amount, 2) }}</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <th><strong>Total Amount</strong></th>
                                        <td class="text-end">
                                            <strong>${{ number_format($billing->total_amount, 2) }}</strong></td>
                                    </tr>
                                </table>

                                @if ($billing->reservation->services->count() > 0)
                                    <h5 class="mt-4">Service Details</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Service</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($billing->reservation->services as $service)
                                                    <tr>
                                                        <td>{{ $service->service->name }}</td>
                                                        <td>{{ $service->quantity }}</td>
                                                        <td>${{ number_format($service->price, 2) }}</td>
                                                        <td>${{ number_format($service->price * $service->quantity, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Customer Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $billing->reservation->customer->first_name }}
                                            {{ $billing->reservation->customer->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $billing->reservation->customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $billing->reservation->customer->phone }}</td>
                                    </tr>
                                    @if ($billing->reservation->customer->is_company && $billing->reservation->customer->company_name)
                                        <tr>
                                            <th>Company</th>
                                            <td>{{ $billing->reservation->customer->company_name }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5>Reservation Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Room</th>
                                        <td>{{ $billing->reservation->room->room_number }}
                                            ({{ ucfirst($billing->reservation->room->room_type) }})</td>
                                    </tr>
                                    <tr>
                                        <th>Check-in</th>
                                        <td>{{ $billing->reservation->check_in_date->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Check-out</th>
                                        <td>{{ $billing->reservation->check_out_date->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nights</th>
                                        <td>{{ $billing->reservation->nights }}</td>
                                    </tr>
                                    <tr>
                                        <th>Guests</th>
                                        <td>{{ $billing->reservation->number_of_guests }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($billing->payment_status == 'pending')
        <!-- Payment Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Process Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('billings.processPayment', $billing) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method *</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="cash">Cash</option>
                                    <option value="credit_card">Credit Card</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="payment_details" class="form-label">Payment Details</label>
                                <textarea class="form-control" id="payment_details" name="payment_details" rows="3"
                                    placeholder="Credit card details, transaction ID, or other payment information"></textarea>
                            </div>
                            <div class="alert alert-info">
                                <strong>Total Amount: ${{ number_format($billing->total_amount, 2) }}</strong>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Confirm Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
