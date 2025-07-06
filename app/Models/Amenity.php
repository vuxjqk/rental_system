<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['name', 'description'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_amenities');
    }
}
