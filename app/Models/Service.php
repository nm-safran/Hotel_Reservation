<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'type'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function reservationServices()
    {
        return $this->hasMany(ReservationService::class);
    }
}
