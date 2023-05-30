@extends('layouts.admin')
@section('page-title')
    {{__('Accounts')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Reports')}}</a></li>
    <li class="breadcrumb-item">{{__('Accounts')}}</li>
@endsection

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                    {{ Form::open(array('route' => array('report.accounts'),'method' => 'GET','id'=>'report_accounts')) }}
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('year', __('Year'),['class'=>'form-label'])}}

                                            {{ Form::select('year',$yearList,isset($_GET['year'])?$_GET['year']:'', array('class' => 'form-control select')) }}
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto mt-4">

                                        <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('report_accounts').submit(); return false;" data-bs-toggle="tooltip" title="{{__('Apply')}}" data-original-title="{{__('apply')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>

                                        <a href="{{route('report.accounts')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                        </a>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="pb-3">{{__('Accounts')}}</h5>
                            <div class="table-responsive mt-3 mb-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="85%">{{__('Income')}}</th>
                                            {{--@foreach($month as $m)
                                                <th width="15%">{{$m}}</th>
                                            @endforeach--}}
                                            <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td width="85%" class="text-dark"><span>{{__('Uncategorized Income')}}</span></td>
                                        <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></td>
                                    </tr>
                                    @foreach($incomes as $income)
                                        <tr>
                                            <td width="85%" class="text-dark"><a href="/revenue">{{$income->name_account.' - '.$income->name_type }}</a></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important">{{\Auth::user()->priceFormat($income->amount)}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td width="85%" class="text-dark" style="color:#000 !important;font-weight:bold !important;"><span>{{__('Total Income')}}</span></td>
                                        @if(!empty($totalIncome))
                                                <td width="15%" class="text-dark" style="color:#000 !important;font-weight:bold !important; font-size:12px !important">{{\Auth::user()->priceFormat($totalIncome)}}</td>
                                        @else
                                            <td width="15%" class="text-dark" style="color:#000 !important;font-weight:bold !important; font-size:12px !important"><strong>{{'$0,00'}}</strong></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td width="100%" class="text-dark"><span></td>
                                    </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th width="85%">{{__('Total Cost of Goods Sold')}}</th>
                                            @if(!empty($totalIncome1))
                                                    <th width="15%" >{{\Auth::user()->priceFormat($totalIncome)}}</td>
                                            @else
                                                <th width="15%" ><span>{{'$0,00'}}</span></td>
                                            @endif
                                        </tr>
                                    </thead>
                                        <tr>
                                        <td width="100%" class="text-dark"><span></td>
                                    </tr>
                                    <thead>
                                        <tr>
                                            <th width="85%">{{__('Gross Profit')}}</th>
                                            @if(!empty($totalIncome))
                                                    <th width="15%" >{{\Auth::user()->priceFormat($totalIncome)}}</td>
                                            @else
                                                <th width="15%" ><span>{{'$0,00'}}</span></td>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td  width="100%" class="text-dark"><span></td>
                                    </tr>
                                    <thead>
                                        <tr>
                                            <th width="85%">{{__('Operating Expense')}}</th>
                                            <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="85%" class="text-dark"><span>{{__('Uncategorized Expense')}}</span></td>
                                        
                                             @if(!empty($totalIncome1))
                                                @foreach($totalIncome1 as $income)
                                                    <td width="15%" class="text-dark" style="font-size:12px !important">{{\Auth::user()->priceFormat($income)}}</td>
                                                @endforeach
                                            @else
                                                <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></td>
                                            @endif
                                        </tr>
                                        @foreach($expenses as $expense)
                                            <tr>
                                                <td width="85%" class="text-dark">{{$expense->name_account.' - '.$expense->name_type }}</td>
                                                <td width="15%" class="text-dark" style="font-size:12px !important">{{\Auth::user()->priceFormat($expense->amount)}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td width="85%" class="text-dark" style="color:#000 !important;font-weight:bold !important;"><span>{{__('Total Operating Expenses')}}</span></td>
                                            @if(!empty($totalExpense))
                                                    <td width="15%" style="color:#000 !important;font-weight:bold !important; font-size:12px !important">{{\Auth::user()->priceFormat($totalExpense)}}</td>
                                            @else
                                                <td width="15%" class="text-dark" style="color:#000 !important;font-weight:bold !important; font-size:12px !important">>{{'$0,00'}}</td>
                                            @endif
                                    </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th width="85%" >{{__('Net Profit')}}</th>
                                            @if(!empty($TotalNetProfit))
                                                    <th width="15%"  >{{\Auth::user()->priceFormat($TotalNetProfit)}}</td>
                                            @else
                                                <th width="15%" ><span>{{'$0,00'}}</span></td>
                                            @endif
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
