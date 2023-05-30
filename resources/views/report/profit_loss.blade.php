@extends('layouts.admin')
<style>
    .linea {
        margin:0px 20px;
        width:90px;    
        border-top:1px solid #999;
        position: relative;
        top:10px;
        float:left;
    }

    .contexto {
        font-weight:bold;
        float:left;
    }
</style>
@section('page-title')
    {{__('Protfit & Loss')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Protfit & Loss')}}</li>
@endsection
@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 " id="multiCollapseExample1">
                <div class="card mb-0" style="background-color: #f8f9fd; box-shadow: none;">
                    <div class="card-body">
                    {{ Form::open(array('route' => array('report.profit.loss.total'),'method' => 'GET','id'=>'report_profit_loss_total')) }}
                        <div class="row">
                            <div class="col-xl-10">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                            Date Range 1
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{Form::date('start_date',isset($_GET['start_date'])?$_GET['start_date']:date('Y-m-d'),array('class'=>'month-btn form-control'))}}
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{Form::date('end_date',isset($_GET['end_date'])?$_GET['end_date']:date('Y-m-d'),array('class'=>'month-btn form-control'))}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                            Date Range 2 (prior period)
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{Form::date('start_date1',isset($_GET['start_date1'])?$_GET['start_date1']:date('Y-m-d'),array('class'=>'month-btn form-control'))}}
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{Form::date('end_date1',isset($_GET['end_date1'])?$_GET['end_date1']:date('Y-m-d'),array('class'=>'month-btn form-control'))}}
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="row mt-4">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                            Report Type
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                        {{ Form::select('year',$yearList,isset($_GET['year'])?$_GET['year']:'', array('class' => 'form-control select')) }}
                                    </div>
                                </div>-->
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto mt-4">
                                        <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('report_profit_loss_total').submit(); return false;" data-bs-toggle="tooltip" title="{{__('Apply')}}" data-original-title="{{__('apply')}}">
                                            Update
                                        </a>

                                        <!--<a href="{{route('report.accounts')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                        </a>-->
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
        <div class="col-xl-12">
        <div class="card"  style="box-shadow: none;">
                <div class="card-body table-border-style">
            <div class="row mt-4">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12" style="border-right:1px solid #dadada; ">
                    <center><span style="font-weight:bold;">Net Protfit For Date Range 1</span></center>
                    <center><span style="font-weight:bold;font-size:28px">{{\Auth::user()->priceFormat($totalIncomeRangeDate1-$totalExpensesRangeDate1)}}</span></center>
                    <center><span style="font-weight:bold;">0,00% of Total Income</span></center>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12" style="border-right:1px solid #dadada">
                    <center><span style="font-weight:bold;">Net Protfit For Date Range 2</span></center>
                    <center><span style="font-weight:bold;font-size:28px">{{\Auth::user()->priceFormat($totalIncomeRangeDate2-$totalExpensesRangeDate2)}}</span></center>
                    <center><span style="font-weight:bold;">0,00% of Total Income</span></center>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <center><span style="font-weight:bold;color:#BD371A">Chage In Net Profit</span></center>
                    <center><span style="font-weight:bold;font-size:28px;color:#BD371A">{{\Auth::user()->priceFormat($totalChange-$totalExpensesChange)}}</span></center>
                    <center><span style="font-weight:bold;color:#BD371A">A decrease of 0,00%</span></center>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12" style="display: flex; justify-content:center;">
                    <div class="linea">&nbsp;</div>
                    <div class="btn-group btn-group-toggle contexto" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="options" id="option_a1" autocomplete="off" checked=""> Summary
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="options" id="option_a2" autocomplete="off"> Details
                        </label>
                    </div>
                    <div class="linea">&nbsp;</div>
                </div>
            </div>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="table-responsive mt-3 mb-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td width="48%" class="text-dark" Style="font-weight:bold;"><span>{{__('Account')}}</span></td>
                                            <td width="15%" class="text-dark" style="font-weight:bold;"><span>{{$start_date}}<br>to {{$end_date}}</span></td>
                                            <td width="15%" class="text-dark" style="font-weight:bold;"><span>{{$start_date1}}<br>to {{$end_date1}}</span></td>
                                            <td colspan="2" class="text-dark" style="font-weight:bold;"><center><span>{{__('Change')}}</span></center></td>
                                            <td width="15%" class="text-dark" style="font-weight:bold;"></td>

                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th width="25%">{{__('Income')}}</th>
                                            {{--@foreach($month as $m)
                                                <th width="15%">{{$m}}</th>
                                            @endforeach--}}
                                            <th width="15%"></th>
                                            <th width="15%"></th>
                                            <th width="15%"></th>
                                            <th width="15%"></th>
                                            <th width="15%"></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td width="25%" class="text-dark"><span>{{__('Uncategorized Income')}}</span></td>
                                        <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></td>
                                        <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></td>
                                        <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></td>
                                        <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{'%0.00'}}</span></td>
                                        <td width="15%" class="text-dark" style="font-size:12px !important"></td>
                                    </tr>
                                    @foreach($incomes as $income)
                                        <tr>
                                            <td width="25%" class="text-dark"><a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ route('revenue.edit',$income->account_id) }}" data-ajax-popup="true">{{$income->name_account.' - '.$income->name_type }}</a></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important">{{\Auth::user()->priceFormat($income->amount_date1)}}</td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($income->amount_date2)}}</span></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($income->total_change)}}</span></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{$income->porcentaje_change.'%'}}</span></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td width="25%" class="text-dark" style="color:#000 !important;font-weight:bold !important;"><span>{{__('Total Income')}}</span></td>
                                        <td width="15%" class="text-dark" style="color:#000 !important;font-weight:bold !important; font-size:12px !important">{{\Auth::user()->priceFormat($totalIncomeRangeDate1)}}</td>
                                        <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($totalIncomeRangeDate2)}}</span></td>
                                        <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($totalChange)}}</span></td>
                                        <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{'%0.00'}}</span></td>
                                        <td width="15%" class="text-dark" style="font-size:12px !important"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-dark"><span></td>
                                    </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th width="25%">{{__('Total Cost of Goods Sold')}}</th>
                                            <th width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></th>
                                            <th width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></th>
                                            <th width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></th>
                                            <th width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></th>
                                            <th width="15%" class="text-dark" style="font-size:12px !important"></th>
                                            
                                        </tr>
                                    </thead>
                                        <tr>
                                            <td colspan="6" class="text-dark"><span></td>
                                        </tr>
                                    <thead>
                                        <tr>
                                            <th width="25%">{{__('Gross Profit')}}</th>
                                                <th width="15%" class="text-dark" style="font-size:12px !important">{{\Auth::user()->priceFormat($totalIncomeRangeDate1)}}</td>
                                                <th width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($totalIncomeRangeDate2)}}</span></th>
                                                <th width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($totalChange)}}</span></th>
                                                <th width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></th>
                                                <th width="15%" class="text-dark" style="font-size:12px !important"></th>

                                        </tr>
                                    </thead>
                                    <tr>
                                        <td  colspan="6" class="text-dark"><span></td>
                                    </tr>
                                    <thead>
                                        <tr>
                                            <th width="25%">{{__('Operating Expense')}}</th>
                                            <th width="15%"></th>
                                            <th width="15%"></th>
                                            <th width="15%"></th>
                                            <th width="15%"></th>
                                            <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="25%" class="text-dark"><span>{{__('Uncategorized Expense')}}</span></td>
                                            <td width="15%" class="text-dark" style="color:#000 !important;font-weight:bold !important; font-size:12px !important"><strong>{{'$0,00'}}</strong></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{'$0,00'}}</span></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"></td>                                            
                                        </tr>
                                        @foreach($expenses as $expense)
                                            <tr>
                                                <td width="25%" class="text-dark">{{$expense->name_account.' - '.$expense->name_type }}</td>
                                                <td width="15%" class="text-dark" style="font-size:12px !important">{{\Auth::user()->priceFormat($expense->amount_date1)}}</td>
                                                <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($expense->amount_date2)}}</span></td>
                                                <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($expense->total_change)}}</span></td>
                                                <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{$expense->porcentaje_change.'%'}}</span></td>
                                                <td width="15%" class="text-dark" style="font-size:12px !important"></td>

                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td width="25%" class="text-dark" style="color:#000 !important;font-weight:bold !important;"><span>{{__('Total Operating Expenses')}}</span></td>
                                            <td width="15%" class="text-dark" style="color:#000 !important;font-weight:bold !important; font-size:12px !important">{{\Auth::user()->priceFormat($totalExpensesRangeDate1)}}</td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($totalExpensesRangeDate2)}}</span></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($totalExpensesChange)}}</span></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"><span></span></td>
                                            <td width="15%" class="text-dark" style="font-size:12px !important"></td>
                                    </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th width="25%" >{{__('Net Profit')}}</th>
                                                <th width="15%"  >{{\Auth::user()->priceFormat($totalIncomeRangeDate1-$totalExpensesRangeDate1)}}</td>
                                                <th width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($totalIncomeRangeDate2-$totalExpensesRangeDate2)}}</span></th>
                                                <th width="15%" class="text-dark" style="font-size:12px !important"><span>{{\Auth::user()->priceFormat($totalChange-$totalExpensesChange)}}</span></th>
                                                <th width="15%" class="text-dark" style="font-size:12px !important"><span></span></th>
                                                <th width="15%" class="text-dark" style="font-size:12px !important"><i class="fa-sharp fa-solid fa-chart-line-up"></i></th>
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