<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @section('page-title')
    {{__('Payment request')}}
@endsection
    @section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Payments request')}}</li>
@endsection


    <div class="float-end mb-2">

            <a href="#"  title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
            <a wire:click='$refresh' class="btn btn-warning">reload</a>

    </div>



    <div class="clearfix"></div>
<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
        <div class="icheck-warning d-inline">
            <input type="checkbox" id="checkboxPrimary1" wire:model="status" value="0" wire:loading.attr="disabled">
            <label for="checkboxPrimary1">
            Pendiente
            </label>
        </div>
        <div class="icheck-info d-inline">
            <input type="checkbox" id="checkboxPrimary2" wire:model="status" value="1" wire:loading.attr="disabled">
            <label for="checkboxPrimary2">
            No pagado
            </label>
        </div>
        <div class="icheck-danger d-inline">
            <input type="checkbox" id="checkboxPrimary3" wire:model="status" value="2" wire:loading.attr="disabled">
            <label for="checkboxPrimary3">
            Rechazado
            </label>
        </div>
        <div class="icheck-success d-inline">
            <input type="checkbox" id="checkboxPrimary4" wire:model="status" value="3" wire:loading.attr="disabled">
            <label for="checkboxPrimary4">
            Pagado
            </label>
        </div>
        <div class="icheck-primary d-inline">
            <input type="checkbox" id="checkboxPrimary5" wire:model="status" value="4" wire:loading.attr="disabled">
            <label for="checkboxPrimary5">
            Vencido
            </label>
        </div>
        </div>
        </div>
    </div>
    

    <div class="col-md-12">
        <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="tabla" style="width:100%;cursor:pointer">
                    <thead>
                    <tr>
                        <th class="">Creado el</th>
                        <th class="">Vencimiento</th>
                        <th class="">Empresa</th>
                        <th class="">Tipo de pago</th>
                        <th class="">Periodicidad</th>
                        <th class="">Categoría</th>
                        <th class="">Monto del pago</th>
                        <th class="">Creado por</th>
                        <th class="">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                                function status($st){
                                    $r = [];
                                    switch($st){
                                        case 0:
                                            $r = [
                                                "badge"=>"warning",
                                                "label"=>"Pendiente"
                                            ];
                                        break;
                                        case 1:
                                        $r = [
                                                "badge"=>"info",
                                                "label"=>"No pagado"
                                            ];
                                        break;
                                        case 2:
                                        $r = [
                                                "badge"=>"danger",
                                                "label"=>"Rechazado"
                                            ];
                                        break;
                                        case 3:
                                        $r = [
                                                "badge"=>"success",
                                                "label"=>"Pagado"
                                            ];
                                        break;
                                        case 4:
                                        $r = [
                                                "badge"=>"primary",
                                                "label"=>"Vencido"
                                            ];
                                        break;
                                    }
                                    return '<small class="badge badge-'.$r['badge'].'">'.$r['label'].'</small>';
                                }
    
                            @endphp
                    @forelse ($items as $item)
                        <tr style="cursor:pointer" wire:click="editModal({{$item->id}})">
                            <td>{{$item->created_at}}</td>
                            <td class="">@if($item->date){{ \Carbon\Carbon::parse($item->date)->format("d/m/Y")}} @endif @if($item->day) Día {{$item->day}} de cada mes @endif</td>
                            <td class="">{{$item->company}}</td>
                            <td class="">{{$item->payment_type}}</td>
                            <td class="">{{$item->periodicity}}</td>
                            <td class="">{{$item->category}}</td>
                            <td class="">{{$item->currency}} {{$item->amount}}</td>
                            <td>{{$item->user->name}}</td>
                            <td class="">{!! status($item->status) !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay registros</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>
           
</div>
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush