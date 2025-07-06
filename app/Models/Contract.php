<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'property_id',
        'tenant_id',
        'landlord_id',
        'start_date',
        'end_date',
        'deposit',
        'monthly_rent',
        'status',
        'contract_file_url',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'deposit' => 'decimal:2',
        'monthly_rent' => 'decimal:2',
    ];

    protected $appends = ['contract_file_full_url'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class);
    }

    public function landlord()
    {
        return $this->belongsTo(User::class);
    }

    public function getContractFileFullUrlAttribute()
    {
        return asset('storage/' . $this->contract_file_url);
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['tenant_id'])) {
            $query->where('tenant_id', $filters['tenant_id']);
        }

        if (isset($filters['landlord_id'])) {
            $query->where('landlord_id', $filters['landlord_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    }
}
