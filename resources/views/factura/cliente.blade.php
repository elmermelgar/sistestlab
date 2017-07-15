<div class="row">
    <div class="col-sm-8 factura-cliente">
        <div class="form-group hidden">
            @if($factura)
                <input type="hidden" id="factura_id" name="factura_id" readonly required
                       value="{{$factura->id}}">
            @endif
            <input type="hidden" id="sucursal_id" name="sucursal_id" value="{{$sucursal->id}}" readonly required>
            <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}" readonly required>
        </div>
        <div class="form-group">
            <label for="user_name"
                   class="control-label col-md-2 col-sm-2 col-xs-12">Vendedor: </label>
            <div class="col-md-10 col-sm-10 col-xs-12">
                <input id="user_name" class="form-control input-readonly" readonly value="{{$user->name}}">
            </div>
        </div>
        @if($centro_origen)
            <div class="form-group">
                <label for="recolector_id" class="control-label col-md-2 col-sm-2 col-xs-12">Recolector: </label>
                <div class="col-md-10 col-sm-10 col-xs-12">
                    @if($edit)
                        <select id="recolector_id" name="recolector_id" class="form-control" style="width: 100%"
                                required>
                            <option value="" disabled selected>Seleccione un recolector</option>
                            @foreach($recolectores as $recolector)
                                <option value="{{$recolector->id}}"
                                        @if($recolector->id==($factura? $factura->recolector_id:0)) selected @endif
                                >{{$recolector->getFullName()}}</option>
                            @endforeach
                        </select>
                    @else
                        {{$factura->recolector->getFullName()}}
                    @endif
                </div>
            </div>
        @endif
        <div class="form-group">
            <label for="cliente_id" class="control-label col-md-2 col-sm-2 col-xs-12">Cliente: </label>
            <div class="col-md-10 col-sm-10 col-xs-12">
                @if($edit)
                    <select id="cliente_id" name="cliente_id" class="form-control" style="width: 100%" required>
                        @if($factura)
                            <option value="{{$factura->cliente->id}}"
                                    selected>{{$factura->cliente->razon_social}}</option>
                        @endif
                    </select>
                @else
                    <input id="cliente_id" value="{{$factura->cliente->razon_social}}"
                           class="form-control input-readonly" disabled>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="nit" class="control-label col-md-2 col-sm-2 col-xs-12">NIT: </label>
            <div class="col-md-10 col-sm-10 col-xs-12">
                <input id="nit" class="form-control input-readonly" disabled
                       value="@if($factura){{$factura->cliente->nit}}@endif">
            </div>
        </div>
    </div>
    <div class="col-sm-offset-1 col-sm-3 factura-hora">
        <p><strong>Fecha y Hora:</strong> {{$factura? $factura->created_at:\Carbon\Carbon::now()->toDateTimeString()}}
        </p>
        <p><strong>Condición de pago:</strong> {{$factura? $factura->condicion:null}}</p>
    </div>
</div>