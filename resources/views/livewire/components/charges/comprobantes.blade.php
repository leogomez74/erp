<div>
    {{-- Success is as dangerous as failure. --}}
    @if(count($comprobantes)>0)
    <table class="table">
        <tr>
            <th>Fecha</th>
            <th>Comprobante</th>
        </tr>
        @foreach($comprobantes as $c)
   
        <tr>
            <td>{{$c->created_at}}</td>
            <td><a href="/{{$c->comprobante}}" target="_blank">Comprobante</a></td>
        </tr>
        @endforeach
    </table>
    @endif
</div>
