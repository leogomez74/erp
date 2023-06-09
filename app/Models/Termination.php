<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
    protected $fillable = [
        'employee_id',
        'notice_date',
        'termination_date',
        'termination_type',
        'description',
        'created_by',
    ];

    public function terminationType()
    {
        return $this->hasOne(\App\Models\TerminationType::class, 'id', 'termination_type')->first();
    }

    public function employee()
    {
        return $this->hasOne(\App\Models\Employee::class, 'id', 'employee_id')->first();
    }
}
