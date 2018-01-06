<div class="x_panel quick-budget">
    <div class="x_content">
        @include('presupuesto_rapido.title')
        <div class="col-xs-12">
            <h4>PRESUPUESTO RÁPIDO</h4>
            <p>Fecha: {{\Carbon\Carbon::now()->format('d/m/Y')}}</p>
            <p>Cajero: {{$cajero? $cajero->first_name:'-'}}</p>
            <p>Cliente: {{$cliente? $cliente:'-'}}</p>

            <br>
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Precio USD</th>
                    <th>Subtotal USD</th>
                </tr>
                </thead>
                <tbody>
                @forelse($perfiles as $perfil)
                    @php $subtotal=$perfil->price*$cantidades[$loop->index];
                                    $total=$total+$subtotal;
                    @endphp
                    <tr>
                        <td>{{$perfil->name}}</td>
                        <td>{{$cantidades[$loop->index]}}</td>
                        <td>{{$perfil->display_name}}</td>
                        <td>{{$perfil->price}}</td>
                        <td>{{number_format($subtotal,2)}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Sin exámenes o perfiles de exámenes</td>
                    </tr>
                @endforelse
                </tbody>

                <tfoot>
                <tr>
                    <td colspan="5" class="text-right"><h4>TOTAL USD: {{number_format($total,2)}}</h4></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>