<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayType extends Model
{
    use HasFactory;

    protected $table = 'pay_type';

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Customer::class, 'pay_type', 'id');
    }
}
