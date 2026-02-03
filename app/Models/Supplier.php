<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'sup_id';

    protected $fillable = [
        'com_name',
        'contact_name',
        'phone',
        'email',
    ];

    public function items()
    {
        return $this->belongsToMany(
            Item::class,
            'item_supplier',
            'supp_id',
            'item_id'
        )->withTimestamps();
    }
}
