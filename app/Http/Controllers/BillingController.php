<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $billings = Billing::with('reservation.customer', 'reservation.room')->latest()->get();
        return view('billings.index', compact('billings'));
    }

    public function show(Billing $billing)
    {
        $billing->load('reservation.customer', 'reservation.room', 'reservation.services.service');
        return view('billings.show', compact('billing'));
    }

    public function processPayment(Request $request, Billing $billing)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,credit_card',
            'payment_details' => 'nullable|string',
        ]);

        $billing->update([
            'payment_method' => $validated['payment_method'],
            'payment_details' => $validated['payment_details'],
            'payment_status' => 'paid'
        ]);

        return redirect()->route('billings.show', $billing)->with('success', 'Payment processed successfully.');
    }
}
