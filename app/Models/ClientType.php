<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class ClientType extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'client_type';

    public function client()
    {
        return $this->belongsTo(Customer::class,'client_type','id');
    }

}
