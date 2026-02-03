<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BookingItem;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'user_id',
        'status',
        'requested_at',
        'approved_at',
        'approved_by',
        'remarks',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at'  => 'datetime',
    ];

    /**
     * Booking requester (REAL user name)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Booking approver
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Booking items
     */
    public function items()
    {
        return $this->hasMany(BookingItem::class, 'booking_id', 'booking_id');
    }
}
