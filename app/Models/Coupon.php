<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name',
        'code',
        'discount',
        'limit',
        'description',
    ];

    public function used_coupon()
    {
        return $this->hasMany(\App\Models\UserCoupon::class, 'coupon', 'id')->count();
    }
}
