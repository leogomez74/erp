<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{
    protected $fillable = [
        'invoice',
        'customer',
        'amount',
        'date',
    ];

    public function customer()
    {
        return $this->hasOne(\App\Models\Customer::class, 'customer_id', 'customer');
    }
}
