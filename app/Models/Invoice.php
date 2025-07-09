<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'contract_id',
        'tenant_id',
        'total_amount',
        'due_date',
        'status',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
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
