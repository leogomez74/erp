<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'date',
        'amount',
        'account_id',
        'vender_id',
        'description',
        'category_id',
        'payment_method',
        'reference',
        'created_by',
    ];

    public function category()
    {
        return $this->hasOne(\App\Models\ProductServiceCategory::class, 'id', 'category_id');
    }

    public function vender()
    {
        return $this->hasOne(\App\Models\Vender::class, 'id', 'vender_id');
    }

    public function bankAccount()
    {
        return $this->hasOne(\App\Models\ChartOfAccount::class, 'id', 'account_id');
    }
}
