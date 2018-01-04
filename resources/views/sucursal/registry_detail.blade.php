<table class="table">
    <thead>
    <tr>
        <th data-field="stamp" data-sortable="true">Fecha</th>
        <th data-field="hora" data-sortable="true">Hora</th>
        <th data-field="estado" data-sortable="true">Estado</th>
        <th data-field="user" data-sortable="true">Usuario</th>
        <th data-field="efectivo" data-sortable="true">Efectivo</th>
        <th data-field="debito" data-sortable="true">Débito</th>
        <th data-field="credito" data-sortable="true">Deuda</th>
        <th data-field="costo" data-sortable="true">Costo</th>
        <th data-field="pago" data-sortable="true">Pagos</th>
        <th data-field="cobros" data-sortable="true">Cobros</th>
        <th data-field="venta" data-sortable="true">Facturación (USD)</th>
    </tr>
    </thead>

    <tbody>
    @php $row_style='white';$count=count($registros)@endphp
    @if($count)
        @for($i=0;$i<$count;$i+=2)
            <tr style="background: {{$row_style}}">
                @if($registros[$i]->date==$registros[$i+1]->date)
                    <td rowspan="2">{{$registros[$i]->date}}</td>
                @else
                    <td>{{$registros[$i]->date}}</td>
                @endif
                <td>{{$registros[$i]->time?:'-'}}</td>
                <td>{{$registros[$i]->state?:'-'}}</td>
                <td>{{$registros[$i]->name?:'-'}}</td>
                <td>{{$registros[$i]->cash?:'-'}}</td>
                <td>{{$registros[$i]->debit?:'-'}}</td>
                <td>{{$registros[$i]->debt?:'-'}}</td>
                <td>{{$registros[$i]->cost? '('.$registros[$i]->cost.')':'-'}}</td>
                <td>{{$registros[$i]->payment?:'-'}}</td>
                <td>{{$registros[$i]->charge?:'-'}}</td>
                <td>{{$registros[$i]->billing?:'-'}}</td>
            </tr>
            <tr style="background: {{$row_style}}; border-bottom: 2px solid grey">
                @if($registros[$i]->date!=$registros[$i+1]->date)
                    <td>{{$registros[$i+1]->date}}</td>
                @endif
                <td>{{$registros[$i+1]->time}}</td>
                <td>{{$registros[$i+1]->state}}</td>
                <td>{{$registros[$i+1]->name}}</td>
                <td>{{$registros[$i+1]->cash}}</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>

            @switch($row_style)
                @case('white')
                @php $row_style='whitesmoke'; @endphp
                @break
                @case('whitesmoke')
                @php $row_style='white'; @endphp
                @break
            @endswitch

        @endfor
    @else
        <tr>
            <td colspan="11">Sin registros!</td>
        </tr>
    @endif

    </tbody>

</table>