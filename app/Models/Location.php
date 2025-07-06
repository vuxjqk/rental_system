<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['parent_id', 'name', 'type'];

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }
}
