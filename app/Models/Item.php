<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- import

class Item extends Model
{
    use SoftDeletes; // <-- enable soft deletes

    protected $table = 'items';
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'category_id',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function suppliers()
    {
        return $this->belongsToMany(
            Supplier::class,
            'item_supplier',
            'item_id',
            'supp_id'
        )->withTimestamps();
    }

    public function bookingItems()
    {
        return $this->hasMany(
            \App\Models\BookingItem::class,
            'item_id',
            'item_id'
        );
    }
}
