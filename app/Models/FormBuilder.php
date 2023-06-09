<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormBuilder extends Model
{
    protected $fillable = [
        'form_id',
        'name',
        'type',
        'created_by',
    ];

    public static $fieldTypes = [
        'text' => 'Text',
        'email' => 'Email',
        'number' => 'Number',
        'date' => 'Date',
        'textarea' => 'Textarea',
    ];

    public function form_field()
    {
        return $this->hasMany(\App\Models\FormField::class, 'form_id', 'id');
    }

    public function fieldResponse()
    {
        return $this->hasOne(\App\Models\FormFieldResponse::class, 'form_id', 'id');
    }

    public function response()
    {
        return $this->hasMany(\App\Models\FormResponse::class, 'form_id', 'id');
    }
}
