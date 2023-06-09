<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    protected $fillable = [
        'user',
        'coupon',
    ];

    public function userDetail()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'user');
    }

    public function coupon_detail()
    {
        return $this->hasOne(\App\Models\Coupon::class, 'id', 'coupon');
    }
}
