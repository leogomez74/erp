<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductService extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'sale_price',
        'purchase_price',
        'tax_id',
        'category_id',
        'unit_id',
        'type',
        'created_by',
    ];

    public function taxes()
    {
        return $this->hasOne(\App\Models\Tax::class, 'id', 'tax_id')->first();
    }

    public function products()
    {
        return $this->hasMany(\App\Models\ProductPurchase::class, 'product_id', 'id');
    }

    public function unit()
    {
        return $this->hasOne(\App\Models\ProductServiceUnit::class, 'id', 'unit_id')->first();
    }

    public function category()
    {
        return $this->hasOne(\App\Models\ProductServiceCategory::class, 'id', 'category_id');
    }

    public function tax($taxes)
    {
        $taxArr = explode(',', $taxes);

        $taxes = [];
        foreach ($taxArr as $tax) {
            $taxes[] = Tax::find($tax);
        }

        return $taxes;
    }

    public function taxRate($taxes)
    {
        $taxArr = explode(',', $taxes);
        $taxRate = 0;
        foreach ($taxArr as $tax) {
            $tax = Tax::find($tax);
            $taxRate += $tax->rate;
        }

        return $taxRate;
    }

    public static function taxData($taxes)
    {
        $taxArr = explode(',', $taxes);

        $taxes = [];
        foreach ($taxArr as $tax) {
            $taxesData = Tax::find($tax);
            $taxes[] = ! empty($taxesData) ? $taxesData->name : '';
        }

        return implode(',', $taxes);
    }
}
