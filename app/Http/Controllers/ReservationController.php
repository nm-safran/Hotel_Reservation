<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Billing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['customer', 'room'])->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create(Request $request)
    {
        $room = null;
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;
        $guests = $request->guests;

        if ($request->room_id) {
            $room = Room::findOrFail($request->room_id);
        }

        $customers = Customer::all();
        $rooms = Room::where('status', 'available')->get();

        return view('reservations.create', compact('room', 'checkIn', 'checkOut', 'guests', 'customers', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'credit_card_number' => 'nullable|string',
            'credit_card_expiry' => 'nullable|string',
            'credit_card_name' => 'nullable|string',
            'is_block_booking' => 'boolean',
            'number_of_rooms' => 'required_if:is_block_booking,true|integer|min:1',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        // Check if room is available
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);

        if (!$room->isAvailable($checkIn, $checkOut)) {
            return back()->withInput()->with('error', 'Selected room is not available for the chosen dates.');
        }

        $validated['has_credit_card'] = !empty($validated['credit_card_number']);
        $validated['status'] = 'confirmed';

        // Calculate total amount
        $nights = $checkOut->diffInDays($checkIn);
        $validated['total_amount'] = $room->getRateForPeriod($nights);

        $reservation = Reservation::create($validated);

        // Update room status if it's a block booking
        if ($request->is_block_booking) {
            // For block booking, we might need to handle multiple rooms
            // This is a simplified implementation
            $room->update(['status' => 'occupied']);
        }

        return redirect()->route('reservations.show', $reservation)->with('success', 'Reservation created successfully.');
    }

    public function storePublic(Request $request)
    {
        // Validate customer data
        $customerData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        // Validate reservation data
        $reservationData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'credit_card_number' => 'nullable|string',
            'credit_card_expiry' => 'nullable|string',
            'credit_card_name' => 'nullable|string',
        ]);

        // Create or find customer
        $customer = Customer::firstOrCreate(
            ['email' => $customerData['email']],
            $customerData
        );

        $room = Room::findOrFail($reservationData['room_id']);

        // Check if room is available
        $checkIn = Carbon::parse($reservationData['check_in_date']);
        $checkOut = Carbon::parse($reservationData['check_out_date']);

        if (!$room->isAvailable($checkIn, $checkOut)) {
            return back()->withInput()->with('error', 'Selected room is not available for the chosen dates.');
        }

        $reservationData['customer_id'] = $customer->id;
        $reservationData['has_credit_card'] = !empty($reservationData['credit_card_number']);
        $reservationData['status'] = 'confirmed';

        // Calculate total amount
        $nights = $checkOut->diffInDays($checkIn);
        $reservationData['total_amount'] = $room->getRateForPeriod($nights);

        $reservation = Reservation::create($reservationData);

        return redirect()->route('welcome')->with('success', 'Reservation created successfully. Your confirmation number is: ' . $reservation->id);
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['customer', 'room', 'services.service', 'billing']);
        $services = Service::all();
        return view('reservations.show', compact('reservation', 'services'));
    }

    public function edit(Reservation $reservation)
    {
        $customers = Customer::all();
        $rooms = Room::all();
        return view('reservations.edit', compact('reservation', 'customers', 'rooms'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'check_out_date' => 'required|date|after:check_in_date',
            'special_requests' => 'nullable|string',
        ]);

        $reservation->update($validated);

        return redirect()->route('reservations.show', $reservation)->with('success', 'Reservation updated successfully.');
    }

    public function checkIn(Reservation $reservation)
    {
        if ($reservation->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed reservations can be checked in.');
        }

        $reservation->update([
            'status' => 'checked_in',
            'room->status' => 'occupied'
        ]);

        $reservation->room->update(['status' => 'occupied']);

        return back()->with('success', 'Guest checked in successfully.');
    }

    public function checkOut(Reservation $reservation)
    {
        if ($reservation->status !== 'checked_in') {
            return back()->with('error', 'Only checked-in reservations can be checked out.');
        }

        // Calculate final bill
        $billData = $reservation->calculateTotal();

        $billing = Billing::create([
            'reservation_id' => $reservation->id,
            'room_charges' => $billData['room_charge'],
            'service_charges' => $billData['service_charge'],
            'tax_amount' => $billData['tax'],
            'total_amount' => $billData['total'],
            'payment_method' => 'cash', // Default, can be changed during payment
            'payment_status' => 'pending'
        ]);

        $reservation->update([
            'status' => 'checked_out',
            'room->status' => 'available'
        ]);

        $reservation->room->update(['status' => 'available']);

        return redirect()->route('billings.show', $billing)->with('success', 'Guest checked out successfully. Please process payment.');
    }

    public function cancel(Reservation $reservation)
    {
        if (!in_array($reservation->status, ['confirmed', 'checked_in'])) {
            return back()->with('error', 'Cannot cancel reservation in current status.');
        }

        $reservation->update([
            'status' => 'cancelled',
            'room->status' => 'available'
        ]);

        $reservation->room->update(['status' => 'available']);

        return back()->with('success', 'Reservation cancelled successfully.');
    }

    public function addService(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
            'service_date' => 'required|date',
        ]);

        $service = Service::findOrFail($validated['service_id']);

        $reservation->services()->create([
            'service_id' => $service->id,
            'quantity' => $validated['quantity'],
            'price' => $service->price,
            'service_date' => $validated['service_date']
        ]);

        return back()->with('success', 'Service added successfully.');
    }
}
