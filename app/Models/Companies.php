<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $fillable = [
        'name',
    ];

    public static function setCompanies()
    {
        return Companies::get();
    }
}
