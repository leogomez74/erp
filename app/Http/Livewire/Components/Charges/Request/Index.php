<?php

namespace App\Http\Livewire\Components\Charges\Request;

use App\Models\Charges;
use Gnumarquez\Whatsapp;
use Livewire\Component;

class Index extends Component
{
    public $items = [];

    public $companies = [
        'Ecopal',
        'Credipep',
        'DSF',
        'ITD',
        'Nanas',
        'Hermosa',
        'Minigolf',
        'Snap',
        'Villa Alta',
        'Otro',
    ];

    public $categories = ['Luz', 'Agua', 'Teléfono', 'Internet', 'Gasolina', 'Alquiler', 'Salario', 'Extras', 'Bono', 'Materiales de oficina', 'Materiales de construcción', 'Otro'];

    public $charge = [];

    public $charge2 = [];

    public $status = [0, 1, 2, 3, 4];

    public $cobro;

    protected $queryString = [
        'status',
        'cobro' => ['except' => ''],
    ];

    public $approved = false;

    protected $rules = [
        'charge.company' => 'required',
        'charge.payment_type' => 'required',
        'charge.periodicity' => 'required',
        'charge.category' => 'required',
        'charge.amount' => 'required',
    ];

    public $creator;

    public function checkPay()
    {
        if ($this->cobro) {
            $this->editModal($this->cobro);
        }
    }

    public function render()
    {
        $this->items = Charges::with('user')->whereIn('status', $this->status);
        if (! auth()->user()->can('ver todo')) {
            $this->items = $this->items->whereCreatedBy(\Auth::id());
        }

        $this->items = $this->items->orderBy('id', 'desc')->get();

        return view('livewire.components.charges.request.index')->extends('layouts.admin');
    }

    public function save()
    {
        $this->charge = [
            array_merge(
                $this->charge,
                ['status' => ($this->approved) ? 1 : 0,
                    'created_by' => auth()->user()->id]
            ),
        ];

        if ($this->charge[0]['periodicity'] == 'Una vez') {
            $this->charge[0]['day'] = null;
        } else {
            $this->charge[0]['date'] = null;
        }
        $cobro = Charges::create($this->charge[0]);
        $this->emit('closeModal');
        $wa = new Whatsapp(false);
        $wa->apiKey = '1FETR4zXAseHaQPNSBl2IWVwM60759ik';
        if ($this->approved) {
            $wa->telf = '584123815725';
            $wa->txt = 'Se creó una nueva solicitud de cobro, aprobado por '.auth()->user()->name.' - https://erp2.ssc.cr/charges/charges?pago='.$cobro->id;
        //A Yoselin: Se creó una nueva solicitud de pago, aprobado por Leonardo Gómez admin.ssc.cr/pagos/pago3495
        } else {
            $wa->telf = '584143815725';
            $wa->txt = 'Se creó una nueva solicitud de cobro por '.auth()->user()->name.', requiere aprobación - https://erp2.ssc.cr/charges/request?cobro='.$cobro->id;
            // Se creó una nueva solicitud de pago, requiere aprobación admin.ssc.cr/pagos/pago3495
            //   /payments/request?pago=10
        }
        $wa->send();
    }

    public function editModal($id)
    {
        $modelo = Charges::find($id);
        $this->creator = $modelo->user->name;
        $this->charge = $modelo->toArray();
        $this->charge2 = $this->charge;
        $this->emit('setComprobanteId', $id);
        $this->emit('ModalEdit');
    }

    public function saveEdit()
    {
        if ($this->charge != $this->charge2) {
            unset($this->charge['created_at']);
            unset($this->charge['updated_at']);
            unset($this->charge['user']);
            if ($this->charge['periodicity'] == 'Una vez') {
                $this->charge['day'] = null;
            } else {
                $this->charge['date'] = null;
            }

            Charges::whereId($this->charge['id'])->update($this->charge);
        }
        $this->emit('ModalEdit');
    }

    public function setStatus($status)
    {
        Charges::whereId($this->charge['id'])->update(['status' => $status]);
        $this->emit('ModalEdit');
    }

    public function updated($field)
    {
        $this->resetValidation($field);
    }
}
