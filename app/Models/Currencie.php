<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencie extends Model
{
    protected $fillable = [
        'name',
        'currency',
        'symbol',
        'created_by',
    ];
}
