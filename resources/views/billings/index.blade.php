@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Billing Records</h3>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Billing ID</th>
                                        <th>Reservation ID</th>
                                        <th>Customer</th>
                                        <th>Room</th>
                                        <th>Total Amount</th>
                                        <th>Payment Status</th>
                                        <th>Payment Method</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($billings as $billing)
                                        <tr>
                                            <td>{{ $billing->id }}</td>
                                            <td>
                                                <a href="{{ route('reservations.show', $billing->reservation_id) }}">
                                                    #{{ $billing->reservation_id }}
                                                </a>
                                            </td>
                                            <td>{{ $billing->reservation->customer->first_name }}
                                                {{ $billing->reservation->customer->last_name }}</td>
                                            <td>{{ $billing->reservation->room->room_number }}</td>
                                            <td>${{ number_format($billing->total_amount, 2) }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $billing->payment_status == 'paid' ? 'success' : ($billing->payment_status == 'pending' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($billing->payment_status) }}
                                                </span>
                                                @if ($billing->is_no_show_charge)
                                                    <br><small class="text-danger">No-show charge</small>
                                                @endif
                                            </td>
                                            <td>{{ ucfirst($billing->payment_method) }}</td>
                                            <td>{{ $billing->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('billings.show', $billing) }}"
                                                    class="btn btn-sm btn-info">View</a>
                                                @if ($billing->payment_status == 'pending')
                                                    <a href="{{ route('billings.show', $billing) }}"
                                                        class="btn btn-sm btn-success">Process Payment</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No billing records found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($billings->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $billings->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
