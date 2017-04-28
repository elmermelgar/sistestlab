<div class="row">
    <div class="col-sm-8"
         style="padding: 15px 10px;border-radius: 1em; border-style: solid; border-color: silver">

        <div class="form-group hidden">
            <label for="sucursal_id"
                   class="control-label col-md-2 col-sm-2 col-xs-12">Sucursal: </label>
            <div class="col-md-10 col-sm-10 col-xs-12">
                <input id="sucursal_id" name="sucursal_id" value="{{$sucursal->id}}" class="form-control"
                       readonly style="background: none;border: none;box-shadow: none">
            </div>
        </div>

        <div class="form-group hidden">
            <label for="user_id"
                   class="control-label col-md-2 col-sm-2 col-xs-12">Vendedor: </label>
            <div class="col-md-10 col-sm-10 col-xs-12">
                <input id="user_id" name="user_id" value="{{$user->id}}" class="form-control"
                       readonly style="background: none;border: none;box-shadow: none">
            </div>
        </div>        <div class="form-group">
            <label for="user_name"
                   class="control-label col-md-2 col-sm-2 col-xs-12">Vendedor: </label>
            <div class="col-md-10 col-sm-10 col-xs-12">
                <input id="user_name" name="user_name" value="{{$user->name}}" class="form-control"
                       readonly style="background: none;border: none;box-shadow: none">
            </div>
        </div>
        @if($centro_origen)
            <div class="form-group">
                <label for="recolector_id" class="control-label col-md-2 col-sm-2 col-xs-12">Recolector: </label>
                <div class="col-md-10 col-sm-10 col-xs-12">
                    @if($edit)
                        <select id="recolector_id" name="recolector_id" class="form-control" style="width: 100%"
                                required>
                            <option value="Seleccione recolector" disabled></option>
                            <option value="" disabled selected>Seleccione recolector</option>
                            @foreach($recolectores as $recolector)
                                <option value="{{$recolector->id}}">{{$recolector->getFullName()}}</option>
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
                    </select>
                @else
                    <input id="cliente_id" value="{{$factura->cliente->razon_social}}" class="form-control"
                           disabled style="background: none;border: none;box-shadow: none">
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="nit" class="control-label col-md-2 col-sm-2 col-xs-12">NIT: </label>
            <div class="col-md-10 col-sm-10 col-xs-12">
                <input id="nit" class="form-control" disabled style="background: none;border: none;box-shadow: none"
                       value="@if(!$edit){{$factura->cliente->nit}}@endif">
            </div>
        </div>

    </div>
    <div class="col-sm-offset-1 col-sm-3"
         style="padding: 15px 10px;border-radius: 1em; border-style: solid; border-color: silver">
        <p><strong>Fecha y Hora:</strong> {{$factura? $factura->created_at:\Carbon\Carbon::now()->toDateTimeString()}}
        </p>
        <p><strong>Condición de pago:</strong> {{$factura? $factura->condicion:null}}</p>
    </div>
</div>