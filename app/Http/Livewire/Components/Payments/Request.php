<?php

namespace App\Http\Livewire\Components\Payments;

use Livewire\Component;

class Request extends Component
{
    public $status = [0,1,2,3,4];
    public $items = [];
    public function render()
    {
        return view('livewire.components.payments.request')->extends("layouts.admin");
    }
}
