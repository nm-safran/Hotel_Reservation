<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Billing;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function occupancy()
    {
        $rooms = Room::all();
        return view('reports.occupancy', compact('rooms'));
    }

    public function financial()
    {
        $revenueData = Billing::where('payment_status', 'paid')
        ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->take(30) // Show last 30 days
        ->get();

        return view('reports.financial', compact('revenueData'));
    }

    public function dailyReport()
    {
        return view('reports.daily');
    }

    public function generateDailyReport(Request $request)
    {
        $request->validate([
            'report_date' => 'required|date',
        ]);

        $date = Carbon::parse($request->report_date);

        // Get no-show reservations
        $noShows = Reservation::where('status', 'confirmed')
            ->whereDate('check_in_date', $date)
            ->where('has_credit_card', false)
            ->get();

        // Create billing records for no-shows
        foreach ($noShows as $reservation) {
            if (!$reservation->billing) {
                $billData = $reservation->calculateTotal();

                Billing::create([
                    'reservation_id' => $reservation->id,
                    'room_charges' => $billData['room_charge'],
                    'service_charges' => 0,
                    'tax_amount' => $billData['tax'],
                    'total_amount' => $billData['room_charge'] + $billData['tax'],
                    'payment_method' => 'credit_card',
                    'payment_status' => 'pending',
                    'is_no_show_charge' => true
                ]);
            }

            $reservation->update(['status' => 'no_show']);
        }

        // Get occupancy data
        $occupiedRooms = Reservation::where('check_in_date', '<=', $date)
            ->where('check_out_date', '>=', $date)
            ->whereIn('status', ['checked_in', 'confirmed'])
            ->count();

        $totalRooms = Room::count();
        $occupancyRate = $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0;

        // Get revenue data
        $revenue = Billing::whereDate('created_at', $date)
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $pendingRevenue = Billing::whereDate('created_at', $date)
            ->where('payment_status', 'pending')
            ->sum('total_amount');

        return view('reports.daily-result', compact(
            'date', 'noShows', 'occupiedRooms', 'totalRooms',
            'occupancyRate', 'revenue', 'pendingRevenue'
        ));
    }
}
