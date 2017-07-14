<div class="row">
    <div class="col-sm-12"
         style="padding-top: 0px;border-radius: 5px; border-style: solid; border-color: silver">
        <table class="table" style="font-size: 10px">
            <tbody>
            <tr>
                <th style="width:50%">Subtotal:</th>
                <td>$250.30</td>
                <th style="width:50%">Subtotal:</th>
                <td>$250.30</td>
            </tr>
            <tr>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
            </tr>
            <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
                <th>Shipping:</th>
                <td>$5.80</td>
            </tr>
            <tr>
                <th>Total:</th>
                <td>$265.24</td>
                <th>Total:</th>
                <td>$265.24</td>
            </tr>
            </tbody>
        </table>
        {{--@if($centro_origen)--}}
            {{--<div class="form-group">--}}
                {{--<label for="recolector_id" class="control-label col-md-2 col-sm-2 col-xs-12">Recolector: </label>--}}
                {{--<div class="col-md-10 col-sm-10 col-xs-12">--}}
                    {{--@if($edit)--}}
                        {{--<select id="recolector_id" name="recolector_id" class="form-control" style="width: 100%"--}}
                                {{--required>--}}
                            {{--<option value="" disabled selected>Seleccione un recolector</option>--}}
                            {{--@foreach($recolectores as $recolector)--}}
                                {{--<option value="{{$recolector->id}}"--}}
                                        {{--@if($recolector->id==($factura? $factura->recolector_id:0)) selected @endif--}}
                                {{-->{{$recolector->getFullName()}}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--@else--}}
                        {{--{{$factura->recolector->getFullName()}}--}}
                    {{--@endif--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--@endif--}}


    </div>
    {{--<div class="col-sm-offset-1 col-sm-3"--}}
         {{--style="padding-top: 10px;border-radius: 5px; border-style: solid; border-color: silver">--}}
        {{--<p><strong>Fecha y Hora:</strong> {{$factura? $factura->created_at:\Carbon\Carbon::now()->toDateTimeString()}}--}}
        {{--</p>--}}
        {{--<p><strong>Condición de pago:</strong> </p>--}}
    {{--</div>--}}
</div>