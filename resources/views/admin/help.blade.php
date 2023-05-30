@extends('layouts.admin')

@section('page-title')
    {{__('Use Guide')}}
@endsection

@section('action-button')
    @if(Auth::user()->type == 'admin')
        <div class="bg-neutral rounded-pill d-inline-block">
            <div class="input-group input-group-sm input-group-merge input-group-flush">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-transparent"><i class="ti ti-search"></i></span>
                </div>
                <input type="text" id="keyword" class="form-control form-control-flush" placeholder="{{__('Search by Name or skill')}}">
            </div>
        </div>
    @endif
@endsection

@push('theme-script')
    @if(Auth::user()->type != 'admin')
        <script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>
        <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    @endif
@endpush

@section('content')
        <div class="row">
            <div class=" col-md-12">
                <h2>Paso Nº 1: CONFIGURE EL SISTEMA</h2>
                <img src="/assets/images/guia1.jpg" width="100%" alt="Guide1">
            </div>
            <hr>
            <div class=" col-md-12">
                <h2>Paso Nº 2: Edite los detalle de la empresa y guarde los cambios</h2>
                <img src="/assets/images/guia2.jpg" width="100%" alt="Guide2">
            </div>
            <hr>
            <div class=" col-md-12">
                <h2>Paso Nº 3:</h2>
                <p><b>Vaya a la seccion de personas y agregue almenos un cliente.</b></p>
                <img src="/assets/images/guia4.jpg" width="100%"alt="Guide2">
            </div>
            <div class=" col-md-12">
                <h2>Paso Nº 4:</h2>
                <p><b>Agregue almenos un Proveedor.</b></p>
                <img src="/assets/images/guia5.jpg" width="100%"  alt="Guide2">
            </div>
            <div class=" col-md-12">
                <h2>Paso Nº 5:</h2>
                <p><b>Agregue almenos una Categoría de producto o servicio.</b></p>
                <img src="/assets/images/guia6.jpg" width="100%"alt="Guide2">
            </div>
            <div class=" col-md-12">
                <h2>Paso Nº 6:</h2>
                <p><b>Agregue almenos un Producto o Servicio.</b></p>
                <img src="/assets/images/guia7.jpg" width="100%" alt="Guide2">
            </div>
            <div class=" col-md-12">
                <h2>Paso Nº 7:</h2>
                <p><b>Agregue almenos un Producto o Servicio.</b></p>
                <img src="/assets/images/guia8.jpg" width="100%"  alt="Guide2">
            </div>
            <div class=" col-md-12">
                <h2>Paso Nº 8:</h2>
                <p><b>Luego vaya a existencia de producto y agregue al menos una cantidad del producto o productos que ha creado</b></p>
                {{--<img src="/assets/images/guia8.jpg" width="100%"  alt="Guide2">--}}
            </div>


        </div>

@endsection


