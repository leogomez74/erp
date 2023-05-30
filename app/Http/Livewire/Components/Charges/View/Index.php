<?php

namespace App\Http\Livewire\Components\Charges\View;

use Livewire\Component;
use App\Models\Charges;
use Gnumarquez\Whatsapp;
//use App\Models\Notification;

use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $items = [];
    public $companies = [
        "Ecopal",
        "Credipep",
        "DSF",
        "ITD",
        "Nanas",
        "Hermosa",
        "Minigolf",
        "Snap",
        "Villa Alta",
        "Otro"
    ];

    public $comprobante;

    public $categories = ["Luz", "Agua", "Teléfono", "Internet", "Gasolina", "Alquiler", "Salario", "Extras", "Bono","Materiales de oficina","Materiales de construcción","Otro"];

    public $charge = [];
    public $charge2 = [];

    public $status = [1,3,4];

    public $cobro;

    protected $queryString = [
        'status',
        'cobro' => ['except' => '']
    ];

    public $approved = false;

    protected $rules = [
        'charge.company'=>"required",
        'charge.charge_type'=>"required",
        'charge.periodicity'=>"required",
        'charge.category'=>"required",
        'charge.amount'=>"required",
    ];

    public $creator;

    protected $listeners = ["upload:finished"=>"upload"];

    public function checkCharge()
    {
        if ($this->cobro){
            $this->editModal($this->cobro);
        }
    }
    
    public function upload($dd,$dd2){
        $this->emit("addComprobante",$dd2);
    }
 
    public function render()
    {
        //dd('hola');
        $this->items = Charges::with("user")->whereIn("status",$this->status)->orWhere("status",0)->orderBy("id","desc")->get();
        return view('livewire.components.charges.view.index')->extends("layouts.admin");
    }

    public function save()
    {
        $this->validate();
        $this->charge = [
            array_merge(
                $this->charge,
                [ "status"=>($this->approved) ? 1 : 0,
                    "created_by"=>auth()->user()->id]
            )
        ];
        if ($this->charge[0]['periodicity'] == "Una vez"){
            $this->charge[0]['day'] = null;
        } else {
            $this->charge[0]['date'] = null;
        }
        Charges::create($this->charge);
        $this->emit("closeModal");
    }

    public function editModal($id)
    {
        $modelo = Charges::find($id);
        $this->comprobante = "";
        $this->creator = $modelo->user->name;
        $this->charge = $modelo ->toArray();
        $this->charge2 = $this->charge;
        $this->emit("setComprobanteId",$id);
        $this->emit("ModalEdit");
    }

    public function saveEdit()
    {

       //dd($this->comprobante);
        
        unset($this->charge['created_at']);
        unset($this->charge['updated_at']);
        unset($this->charge['user']);

        
        $cobro = Charges::find($this->charge['id']);
        if ($cobro->status!=3){
            $this->charge['status']=3;
           /* 
           esta parte no ya que no tenemos notificaciones como en ssc en la barra de arriba, almenos no por ahora
           
           $no = new Notification();
            $no->user_id = $cobro->created_by;
            $no->text = "El Cobro que usted solicitó ha sido cobrado.";
            $no->resource = "/charges/request?cobro=".$this->charge['id'];
            $no->icon = "at";
            $no->type = "1";
            $no->save();
            event(new \App\Events\NotificationEvent($no->user_id));*/
        }
        
        $cobro->update($this->charge);
        if ($this->comprobante){
            $guardar = $this->comprobante->store('comprobantes'); //comprobantes/6kw8bl1dSVthjLQqYTh60v1PrCr601RRbTdSLEIX.jpg
            $cobro->details()->create(["comprobante"=>$guardar]);
        }

        
        $this->emit("ModalEdit");
    }

    public function setStatus($status)
    {
        $pay = Charges::find($this->charge['id']);
        $pay->update(["status"=>$status]);
        
        $this->emit("ModalEdit");
        
    }

    public function updated($field)
    {

        //$this->resetValidation($field);
    }

}
