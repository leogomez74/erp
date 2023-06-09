<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceEmployee extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'status',
        'clock_in',
        'clock_out',
        'late',
        'early_leaving',
        'overtime',
        'total_rest',
        'created_by',
    ];

    public function employees()
    {
        return $this->hasOne(\App\Models\Employee::class, 'user_id', 'employee_id');
    }

    public function employee()
    {
        return $this->hasOne(\App\Models\Employee::class, 'id', 'employee_id');
    }
}
