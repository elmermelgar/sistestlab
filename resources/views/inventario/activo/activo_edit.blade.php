@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="page-title">
        <div class="title_left">
            <ol class="breadcrumb">
                <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ route('activo.index')}}">Activos</a></li>
                <li>@if($activo) Actualizando un activo @else Nuevo activo @endif</li>
            </ol>
        </div>

        <div class="title_right">
            <div class="form-group pull-right">
                <div class="input-group" style="">
                    <a href="{{route('activo.index')}}" style="float: right;" class="btn btn-danger"><i
                                class="fa fa-reply-all"></i> Regresar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        @if($activo) Editando el activo "{{$activo->nombre}}"
                        @else Creando un nuevo activo
                        @endif
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <form class="form-horizontal form-label-left" method="POST" action="
                        @if($activo)
                    {{route('activo.update',$activo->id)}}
                    @else
                    {{route('activo.store')}}
                    @endif ">
                        {{ csrf_field() }}
                        <fieldset>
                            <div class="col-md-8 col-md-offset-1">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Nombre del Activo:
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input name="nombre" placeholder="Nombre del Activo"
                                               class="form-control col-md-7 col-xs-12" required
                                               value="{{$activo? $activo->nombre:old('nombre')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tipo" class="control-label col-md-4 col-sm-3 col-xs-12">Tipo:
                                        <span class="required">*</span></label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <select class="form-control" id="tipo" name="tipo">
                                            <option value="reactivo"
                                                    @if($activo? $activo->tipo=='reactivo':false) selected @endif>
                                                Recurso
                                            </option>
                                            <option value="equipo"
                                                    @if($activo? $activo->tipo=='equipo':false) selected @endif>
                                                Mobiliario y Equipo
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="proveedor_id" class="control-label col-md-4 col-sm-3 col-xs-12">
                                        Proveedor:<span class="required">*</span></label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <select id="proveedor_id" name="proveedor_id" style="width: 100%" required
                                                class="form-control">
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{$proveedor->id}}"
                                                        @if($activo&&$proveedor->id===$activo->proveedor_id) selected
                                                        @endif>{{$proveedor->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="marca" class="control-label col-md-4 col-sm-3 col-xs-12">Marca:
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input id="marca" name="marca" required
                                               class="date-picker form-control col-md-7 col-xs-12"
                                               value="{{$activo? $activo->marca:old('marca')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Modelo:</label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input name="modelo" placeholder="Modelo"
                                               class="form-control col-md-7 col-xs-12"
                                               value="{{$activo? $activo->modelo:old('modelo')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Serie:</label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input name="serie" placeholder="Serie"
                                               class="form-control col-md-7 col-xs-12"
                                               value="{{$activo? $activo->serie:old('serie')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Unidades:</label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input name="unidades" placeholder="mm/ml/m/gal"
                                               class="form-control col-md-7 col-xs-12"
                                               value="{{$activo? $activo->unidades:old('unidades')}}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-12" style="text-align: center">
                                <button type="reset" class="btn btn-dark">
                                    @if($activo) Reestablecer @else Limpiar @endif</button>
                                <button class="btn btn-success">
                                    @if($activo) Actualizar @else Guardar @endif</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{url('gentallela/vendors/select2/dist/js/select2.full.min.js')}}"></script>
@endsection
@section('script-codigo')
    <script>
        $(document).ready(function () {
            moment.locale('es');
            $("#proveedor_id").select2({
                placeholder: "Seleccione un proveedor..."
            });
        });
    </script>
@endsection
