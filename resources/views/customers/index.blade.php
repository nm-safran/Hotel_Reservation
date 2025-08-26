@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Customers</h3>
                        <a href="{{ route('customers.create') }}" class="btn btn-primary">New Customer</a>
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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Type</th>
                                        <th>Reservations</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customers as $customer)
                                        <tr>
                                            <td>{{ $customer->id }}</td>
                                            <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>
                                                @if ($customer->is_company)
                                                    <span class="badge bg-info">Company</span>
                                                    @if ($customer->company_name)
                                                        <br><small>{{ $customer->company_name }}</small>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">Individual</span>
                                                @endif
                                            </td>
                                            <td>{{ $customer->reservations->count() }}</td>
                                            <td>
                                                <a href="{{ route('customers.show', $customer) }}"
                                                    class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('customers.edit', $customer) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No customers found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($customers->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $customers->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
