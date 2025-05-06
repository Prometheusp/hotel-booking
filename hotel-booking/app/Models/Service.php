<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function bookings()
    {
        return $this->hasMany(BookingService::class);
    }
}
