@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Room Management</h3>
                        <a href="{{ route('rooms.create') }}" class="btn btn-primary">Add New Room</a>
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
                                        <th>Room Number</th>
                                        <th>Type</th>
                                        <th>Capacity</th>
                                        <th>Price/Night</th>
                                        <th>Weekly Rate</th>
                                        <th>Monthly Rate</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rooms as $room)
                                        <tr>
                                            <td>{{ $room->room_number }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $room->room_type)) }}</td>
                                            <td>{{ $room->capacity }} guests</td>
                                            <td>${{ number_format($room->price_per_night, 2) }}</td>
                                            <td>${{ number_format($room->weekly_rate, 2) }}</td>
                                            <td>${{ number_format($room->monthly_rate, 2) }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($room->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('rooms.show', $room) }}"
                                                    class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('rooms.edit', $room) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('rooms.destroy', $room) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this room?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No rooms found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($rooms->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $rooms->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
