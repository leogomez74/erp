<div>
    <div class="col-md-12">
        <button class="btn btn-success d-none" wire:click.prevent="$refresh">Reload / dev</button>
        <div class="form-group col-md-6">
            <label for="site_time_format" class="form-label">{{__('Currency *')}}</label>
            <div class="input-group">
                <select
                    type="text"
                    name="site_time_format"
                    class="form-control selectric"
                    wire:model.model="selected_currency">
                    <option value="" disabled="disabled">--</option>
                    @foreach ($currency_list as $key=>$item)
                    @if(in_array($key,$currencies->pluck('currency')->toArray())) @continue @endif
                    <option value="{{$key}}">{{$item['name']}}
                        -
                        {{$item['symbol']}}</option>
                    @endforeach
                </select>

                <button class="btn btn-primary m-r-10" wire:click.prevent="addCurrency" {{$selected_currency ? '':'disabled'}}>
                    +
                </button>
            </div>
        </div>
    </div>
    <table class="table mb-4">
        <tr>
            <th>Currency</th>
            <th>Name</th>
            <th>Symbol</th>
            <th>Default</th>
            <th></th>
        </tr>
        @forelse($currencies as $item)
        <tr>
            <td>{{$item->currency}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->symbol}}</td>
            <td>
            <input
                        class="form-check-input"
                        type="radio"
                        value="{{$item->id}}"
                        name="default"
                        wire:model="default"
                        >
            </td>
            <td><button class="btn btn-primary btn-sm" wire:click.prevent="delCurrency({{$item->id}})"><i class="fas fa-trash"></i></button></td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">No se ha seleccionado una moneda</td>
        </tr>
        @endforelse
    </table>
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="example3cols3Input">{{__('Currency Symbol Position')}}</label>
            <div class="row ms-1">
                <div class="form-check col-md-6">
                    <input
                        class="form-check-input"
                        type="radio"
                        value="pre"
                        name="currencyposition"
                        wire:model="currencyPosition">
                        <label class="form-check-label" for="flexCheckDefault">
                            Pre
                        </label>
                    </div>
                    <div class="form-check col-md-6">
                        <input
                            class="form-check-input"
                            type="radio"
                            value="post"
                            name="currencyposition"
                            wire:modeL='currencyPosition'>
                            <label class="form-check-label" for="flexCheckChecked">
                                Post
                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @push("scripts")
<script>
Livewire.on("toaster",(type,msj)=>{
    show_toastr(type,msj);
})
</script>
        @endpush