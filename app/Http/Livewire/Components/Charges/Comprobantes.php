<?php

namespace App\Http\Livewire\Components\Charges;

use App\Models\ChargeDetail;
use Livewire\Component;

class Comprobantes extends Component
{
    public $comprobante_id;

    public $comprobantes = [];

    protected $listeners = ['setComprobanteId', 'addComprobante'];

    public function addComprobante($array)
    {
        foreach ($array as $item) {
            $this->comprobantes = [(object) ['created_at' => now()->format('Y-m-d H:i:s'), 'comprobante' => 'tmp/'.$item], ...$this->comprobantes];
        }
        //   dd($this->comprobantes);
    }

    public function setComprobanteId($id)
    {
        $this->comprobante_id = $id;
        $this->comprobantes = ChargeDetail::wherechargesId($id)->orderBy('id', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.components.charges.comprobantes');
    }
}
