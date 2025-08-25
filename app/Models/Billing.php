<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'room_charges',
        'service_charges',
        'tax_amount',
        'total_amount',
        'payment_method',
        'payment_status',
        'payment_details',
        'is_no_show_charge'
    ];

    protected $casts = [
        'room_charges' => 'decimal:2',
        'service_charges' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'is_no_show_charge' => 'boolean'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
