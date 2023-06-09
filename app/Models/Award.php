<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $fillable = [
        'employee_id',
        'award_type',
        'date',
        'gift',
        'description',
        'created_by',
    ];

    public function awardType()
    {
        return $this->hasOne(\App\Models\AwardType::class, 'id', 'award_type')->first();
    }

    public function employee()
    {
        return $this->hasOne(\App\Models\Employee::class, 'id', 'employee_id')->first();
    }
}
