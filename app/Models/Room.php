<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type',
        'capacity',
        'price_per_night',
        'weekly_rate',
        'monthly_rate',
        'amenities',
        'status'
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'weekly_rate' => 'decimal:2',
        'monthly_rate' => 'decimal:2',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function isAvailable($checkIn, $checkOut)
    {
        return !$this->reservations()
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                    ->orWhere(function($query) use ($checkIn, $checkOut) {
                        $query->where('check_in_date', '<=', $checkIn)
                            ->where('check_out_date', '>=', $checkOut);
                    });
            })
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->exists();
    }

    public function getRateForPeriod($nights)
    {
        if ($nights >= 30 && $this->monthly_rate) {
            return $this->monthly_rate * ceil($nights / 30);
        } elseif ($nights >= 7 && $this->weekly_rate) {
            return $this->weekly_rate * ceil($nights / 7);
        } else {
            return $this->price_per_night * $nights;
        }
    }
}
