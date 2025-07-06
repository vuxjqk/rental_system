<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'landlord_id',
        'location_id',
        'address_detail',
        'type',
        'price',
        'area',
        'max_occupants',
        'status',
        'description',
    ];

    public function landlord()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['landlord_id'])) {
            $query->where('landlord_id', $filters['landlord_id']);
        }

        if (isset($filters['location_id'])) {
            $query->where('location_id', $filters['location_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    }
}
