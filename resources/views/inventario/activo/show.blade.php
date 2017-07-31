@extends('layouts.app')

@section('imports')

@endsection

@section('content')

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ route('activo.index')}}">Activos</a></li>
            <li>{{$activo->nombre}}</li>
            <li class="alignright no-before">
                <a href="{{route('activo.index')}}" class="btn btn-dark btn-sm">
                    <i class="fa fa-reply-all fa-fw"></i>Regresar</a>
            </li>
        </ol>
    </div>

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="row">
        <div class="col-md-5 col-sm-5 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <h3>@if($activo->tipo == "equipo")Activo: @else Reactivo: @endif {{$activo->nombre}}</h3>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_left">
                        <div class="profile_img">
                            <div id="crop-avatar">
                                <!-- Current avatar -->
                                <img class="img-responsive avatar-view" alt="Inventario" title="Inventario"
                                     style="max-height: 200px" src="{{url('/storage/images/'. 'inventario.png')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <h4>{{$activo->nombre_activo}}</h4>

                        <ul class="list-unstyled user_data">
                            <li><h4><i class="fa fa-lock"></i>
                                    Código: <strong>{{$activo->codigo()}}</strong></h4>
                            </li>
                            <li><i class="fa fa-chevron-right user-profile-icon"></i>
                                Tipo: <strong>@if($activo->tipo == "reactivo")Reactivo @else Mobiliario y
                                    Equipo @endif</strong>
                            </li>
                            <li><i class="fa fa-male user-profile-icon"></i>
                                Proveedor: <strong>{{$activo->proveedor->nombre}}</strong>
                            </li>
                            @if($activo->tipo == "reactivo")
                                <li><i class="fa fa-thermometer-half user-profile-icon"></i>
                                    Unidades: <strong>{{$activo->unidades}}</strong>
                                </li>
                            @endif
                            <li><i class=" user-profile-icon"></i>
                                Marca: <strong>{{$activo->marca}}</strong>
                            </li>
                            <li><i class=" user-profile-icon"></i>
                                Modelo: <strong>{{$activo->modelo}}</strong>
                            </li>
                            <li><i class=" user-profile-icon"></i>
                                Serie: <strong>{{$activo->serie}}</strong>
                            </li>
                            <li><i class=" user-profile-icon"></i>
                                Observación: <strong>{{$activo->observacion}}</strong>
                            </li>
                        </ul>

                    </div>
                    <a class="btn btn-primary" href="{{route('activo.edit',$activo->id)}}">
                        <i class="fa fa-edit m-right-xs"></i> Editar @if($activo->tipo == "reactivo")Reactivo @else
                            Activo @endif</a>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-sm-7 col-xs-12">


            <div class="x_panel">
                <div class="x_title">
                    <h4>Inventario</h4>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Sucursal</th>
                            <th>Estado</th>
                            <th>Ubicación</th>
                            <th>Cantidad mínima</th>
                            <th>Cantidad máxima</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($activo->inventarios as $inventario)
                            <tr>
                                <td>{{$inventario->sucursal->display_name}}</td>
                                <td>{{$inventario->estado->display_name}}</td>
                                <td>{{$inventario->ubicacion}}</td>
                                <td>{{$inventario->minimo}}</td>
                                <td>{{$inventario->maximo}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Sin registros!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <a href="{{route('activo.edit_inventario',[$activo->id])}}"
                       class="btn btn-round btn-warning"><i class="fa fa-edit"></i> Editar Inventario</a>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if(count($activo->inventarios)>0&&$activo->tipo == "reactivo")
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Existencias</h2>
                        <div class="alignright">
                            <button class="btn btn-round btn-success" data-toggle="modal" data-target="#modal_cargar">
                                <i class="fa fa-upload fa-fw"></i> Cargar
                            </button>
                            <button class="btn btn-round btn-danger" data-toggle="modal" data-target="#modal_descargar">
                                <i class="fa fa-download fa-fw"></i> Descargar
                            </button>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Sucursal</th>
                                <th>Total</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Lote</th>
                                <th>Fecha de adquisición</th>
                                <th>Fecha de vencimiento</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($existencias as $sucursal_existencia)

                                <tr>
                                    <td rowspan="{{count($sucursal_existencia)}}">
                                        {{$sucursal_existencia->first()
                                    ->inventario()->sucursal->display_name}}
                                    </td>
                                    <td rowspan="{{count($sucursal_existencia)}}">
                                        {{$sucursal_existencia->sum('cantidad')}}
                                    </td>
                                    @foreach($sucursal_existencia as $existencia)

                                        <td>{{$existencia->cantidad}}</td>
                                        <td>{{$existencia->precio}}</td>
                                        <td>{{$existencia->lote}}</td>
                                        <td>{{$existencia->fecha_adquisicion}}</td>
                                        <td>{{$existencia->fecha_vencimiento}}</td>
                                </tr>
                                @endforeach

                            @empty
                                <tr>
                                    <td colspan="7">Sin existencias!</td>
                                </tr>

                            @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        @endif
    </div>

    <div id="modal_cargar" class="modal fade">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>×</span>
                    </button>
                    <h4 class="modal-title">Cargar existencias de <i class="text-danger">{{$activo->nombre}}</i></h4>
                </div>

                <form class="form-horizontal form-label-left"
                      action="{{route('activo.cargar',[$activo->id])}}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group hidden">
                                    <input type="hidden" name="activo_id" required readonly value="{{$activo->id}}">
                                </div>
                                <div class="form-group">
                                    <label for="sucursal_add" class="control-label col-md-5 col-sm-4 col-xs-12">
                                        Sucursal:</label>
                                    <div class="col-md-7 col-sm-5 col-xs-12">
                                        <select name="sucursal_id" class="form-control" required>
                                            @foreach($sucursales as $sucursal)
                                                <option value="{{$sucursal->id}}">{{$sucursal->display_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-4 col-xs-12">Cantidad:
                                    </label>
                                    <div class="col-md-7 col-sm-5 col-xs-12">
                                        <input type="number" name="cantidad" placeholder="0"
                                               class="form-control col-md-7 col-xs-12" min="1"
                                               value="{{old('cantidad')}}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="precio" class="control-label col-md-5 col-sm-4 col-xs-12">Precio:
                                        <span class="required">*</span></label>
                                    <div class="col-md-7 col-sm-5 col-xs-12">
                                        <input name="precio" type="number" class="form-control col-md-7 col-xs-12"
                                               placeholder="0.00" step="0.01" min="0.00" required
                                               value="{{old('precio')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-4 col-xs-12">Número de lote:</label>
                                    <div class="col-md-7 col-sm-5 col-xs-12">
                                        <input name="lote" class="form-control col-md-7 col-xs-12"
                                               placeholder="######"
                                               value="{{old('lote')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-4 col-xs-12">Fecha de adquicisión:
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-7 col-sm-5 col-xs-12">
                                        <input id="fecha_adquisicion" name="fecha_adquisicion" placeholder="dd/mm/yyyy"
                                               class="date-picker form-control col-md-7 col-xs-12" required
                                               value="{{\Carbon\Carbon::now()->format('d/m/Y')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-4 col-xs-12">Fecha de vencimiento:
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-7 col-sm-5 col-xs-12">
                                        <input id="fecha_vencimiento" name="fecha_vencimiento"
                                               class="date-picker form-control col-md-7 col-xs-12"
                                               placeholder="00/00/0000" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary">Cargar al inventario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal_descargar" class="modal fade">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>×</span>
                    </button>
                    <h4 class="modal-title">Descargar existencias de <i class="text-danger">{{$activo->nombre}}</i></h4>
                </div>

                <form class="form-horizontal form-label-left"
                      action="{{route('activo.descargar',[$activo->id])}}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group hidden">
                                    <input type="hidden" name="activo_id" required readonly value="{{$activo->id}}">
                                </div>
                                <div class="form-group">
                                    <label for="sucursal_add" class="control-label col-md-5 col-sm-4 col-xs-12">
                                        Sucursal:</label>
                                    <div class="col-md-7 col-sm-5 col-xs-12">
                                        <select name="sucursal_id" class="form-control" required>
                                            @foreach($sucursales as $sucursal)
                                                <option value="{{$sucursal->id}}">{{$sucursal->display_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-4 col-xs-12">Cantidad:
                                    </label>
                                    <div class="col-md-7 col-sm-5 col-xs-12">
                                        <input type="number" name="cantidad" placeholder="0"
                                               class="form-control col-md-7 col-xs-12" min="1"
                                               value="{{old('cantidad')}}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-danger">Descargar del inventario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('js/moment-with-locales.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script>
        moment.locale('es');
        $(document).ready(function () {
            $('#fecha_adquisicion').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                singleDatePicker: true,
                showDropdowns: true
            });
            $('#fecha_vencimiento').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                singleDatePicker: true,
                showDropdowns: true
            });
        });
    </script>
@endsection