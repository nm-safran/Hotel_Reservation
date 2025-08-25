<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'number_of_guests',
        'status',
        'special_requests',
        'credit_card_number',
        'credit_card_expiry',
        'credit_card_name',
        'has_credit_card',
        'total_amount',
        'discount_amount',
        'is_block_booking',
        'number_of_rooms'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'has_credit_card' => 'boolean',
        'is_block_booking' => 'boolean',
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function services()
    {
        return $this->hasMany(ReservationService::class);
    }

    public function billing()
    {
        return $this->hasOne(Billing::class);
    }

    public function getNightsAttribute()
    {
        $checkIn = Carbon::parse($this->check_in_date);
        $checkOut = Carbon::parse($this->check_out_date);
        return $checkOut->diffInDays($checkIn);
    }

    public function calculateTotal()
    {
        $roomCharge = $this->room->getRateForPeriod($this->nights);

        $serviceCharge = $this->services->sum(function($service) {
            return $service->price * $service->quantity;
        });

        $subtotal = $roomCharge + $serviceCharge;
        $discount = $subtotal * ($this->customer->discount_rate / 100);
        $tax = ($subtotal - $discount) * 0.1; // Assuming 10% tax

        return [
            'room_charge' => $roomCharge,
            'service_charge' => $serviceCharge,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $subtotal - $discount + $tax
        ];
    }

    public function isNoShow()
    {
        $today = Carbon::today();
        return $this->status === 'confirmed' &&
               $this->check_in_date->eq($today) &&
               !$this->has_credit_card &&
               Carbon::now()->hour >= 19; // 7 PM
    }
}
