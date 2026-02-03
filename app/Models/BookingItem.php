<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    protected $table = 'booking_items';

    protected $fillable = [
        'booking_id',
        'item_id',
        'quantity',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id')
                ->withTrashed() // <-- include soft-deleted items
                ->withDefault([
                    'name' => 'Item Deleted',
                    'quantity' => 0,
                ]);
    }
}
