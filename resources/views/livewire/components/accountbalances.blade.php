<div>
@section('page-title')
    {{__('Account Balance')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Account Balance')}}</li>
@endsection

<div class="row">
        <div class="offset-sm-1 col-sm-10">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="search">
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="btn-box">
                                            <label for="start_month" class="form-label">{{__('Start Date')}}</label>
                                            <input class="month-btn form-control" wire:model.defer="start_date" type="date">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="btn-box">
                                            <label for="end_month" class="form-label">{{__('End Date')}}</label>
                                            <input class="month-btn form-control" wire:model.defer="end_date" type="date">
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto mt-4">

                                        <button class="btn btn-sm btn-primary">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </button>

                                     


                                    </div>

                                </div>
                            </div>
                        </div>
                    </form></div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="offset-sm-1 col-sm-10">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                <div class="card-header">
                <button class="btn btn-primary" onclick="exportXls()">{{__('Export XLS')}}</button>
                <button class="btn btn-secondary ml-2" onclick="exportPdf()">{{__('Export PDF')}}</button>
                </div>
                    <div class="card-body">
                        <table class="table-sm" id="tablebalance" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{__('ACCOUNTS')}}</th>
                                    <th>{{__('STARTING BALANCE')}}</th>
                                    <th>{{__('DEBIT')}}</th>
                                    <th>{{__('CREDIT')}}</th>
                                    <th>{{__('NET MOVEMENT')}}</th>
                                    <th>{{__('ENDING BALANCE')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accounts as $account)
                                    <tr class="bg-primary" style="color:white;font-weight:bold">
                                        <td colspan="6">
                                        {{__($account['name'])}}
                                        </td>
                                    </tr>
                                    @foreach($account['accounts'] as $acc)
                                    @if($acc['final']==0) @continue @endif
                                    <tr>
                                        <td style="font-weight:bold;color:#24469C">{{$acc['name']}}</td>
                                        <td style="text-align:right">{{auth()->user()->priceFormat($acc['opening_balance'])}}</td>
                                        <td style="text-align:right">{{auth()->user()->priceFormat($acc['debit'])}}</td>
                                        <td style="text-align:right">{{auth()->user()->priceFormat($acc['credit'])}}</td>
                                        <td style="text-align:right">{{auth()->user()->priceFormat($acc['net'])}}</td>
                                        <td style="text-align:right">{{auth()->user()->priceFormat($acc['final'])}}</td>                  
                                    </tr>
                                   
                                    @endforeach
                                    <tr style="font-weight:bold">
                                        <td>Total {{__($account['name'])}}</td>
                                        <td style="text-align:right">{{auth()->user()->priceFormat($account['totalopening'])}}</td>
                                        <td style="text-align:right">{{auth()->user()->priceFormat($account['totaldebit'])}}</td>
                                        <td style="text-align:right">{{auth()->user()->priceFormat($account['totalcredit'])}}</td>
                                        <td style="text-align:right">{{auth()->user()->priceFormat($account['totalnet'])}}</td>
                                        <td style="text-align:right">{{auth()->user()->priceFormat($account['totalfinal'])}}</td>
                                    </tr>
                                     <tr style="height:40px">
                                    <td colspan="6"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push("styles")
<style>
#tablebalance td{
padding:10px;
}
</style>
@endpush
@push("scripts")
<script src="/src/tableHTMLExport.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.10/jspdf.plugin.autotable.min.js"></script>
<script src="/src/jquery.table2excel.js"></script>

<script>

function exportXls(){
    $("#tablebalance").table2excel({
    // exclude CSS class
    exclude:".noExl",
    name:"Worksheet Name",
    filename:"Export",//do not include extension
    fileext:".xls" // file extension

  });

}

function exportPdf(){
    $("#tablebalance").tableHTMLExport({

    // csv, txt, json, pdf
    type:'pdf',
orientation:'p',

    // file name
    filename:'export.pdf'
    
    });
}

</script>
@endpush