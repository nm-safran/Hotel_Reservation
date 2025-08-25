<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationService extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'service_id',
        'quantity',
        'price',
        'service_date'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'service_date' => 'datetime'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
