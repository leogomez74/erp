<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    protected $fillable = [
        'product_id',
        'sale_price',
        'purchase_price',
        'quantity',
        'currency_id',
        'issue_date',
        'created_at',
        'updated_at',
    ];

    /*public function products()
    {
        return $this->hasOne('App\Models\ProductService', 'id', 'product_id')->first();
    }*/
    public function currency()
    {
        return $this->hasOne(\App\Models\Currencie::class, 'id', 'currency_id');
    }
}
