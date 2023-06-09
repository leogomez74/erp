<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanRequest extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'duration',
    ];

    public function plan()
    {
        return $this->hasOne(\App\Models\Plan::class, 'id', 'plan_id');
    }

    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }
}
