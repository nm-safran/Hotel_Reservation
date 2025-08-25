<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'id_type',
        'id_number',
        'company_name',
        'is_company',
        'discount_rate'
    ];

    protected $casts = [
        'is_company' => 'boolean',
        'discount_rate' => 'decimal:2'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function billings()
    {
        return $this->hasManyThrough(Billing::class, Reservation::class);
    }
}
