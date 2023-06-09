<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'employee_id',
        'designation_id',
        'promotion_title',
        'promotion_date',
        'description',
        'created_by',
    ];

    public function designation()
    {
        return $this->hasMany(\App\Models\Designation::class, 'id', 'designation_id')->first();
    }

    public function employee()
    {
        return $this->hasOne(\App\Models\Employee::class, 'id', 'employee_id')->first();
    }
}
