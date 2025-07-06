<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $fillable = [
        'property_id',
        'image_url',
    ];

    protected $appends = ['image_full_url'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function getImageFullUrlAttribute()
    {
        return asset('storage/' . $this->image_url);
    }
}
