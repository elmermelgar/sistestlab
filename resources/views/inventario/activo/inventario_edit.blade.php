@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="page-title">
        <div class="title_left">
            <ol class="breadcrumb">
                <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
                <li>Inventario</li>
                <li>Activo</li>
            </ol>
        </div>

        <div class="title_right">
            <div class="form-group pull-right">
                <div class="input-group" style="">
                    <a href="{{route('activo.index')}}" style="float: right;" class="btn btn-danger">
                        <i class="fa fa-reply-all fa-fw"></i>Regresar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Actualizando datos del inventario</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <form class="form-horizontal form-label-left"
                          action="{{route('activo.updateinventario',[$inventario->id,$activo->id])}}" method="POST">
                        {{ csrf_field() }}
                        {{--Parte 1--}}
                        <fieldset>
                            <legend class="text-danger">{{$activo? $activo->nombre_activo:'Inventario'}}</legend>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Existencia:
                                    </label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="number" name="existencia" placeholder="0"
                                               class="form-control col-md-7 col-xs-12" min="1"
                                               value="{{$inventario->existencia}}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Fecha de Adquicisión:
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input id="birthday" name="fecha_adq" placeholder="dd/mm/yyyy"
                                               class="date-picker form-control col-md-7 col-xs-12" required
                                               value="{{$activo? $activo->fecha_adq:
                                                   \Carbon\Carbon::now()->format('d/m/Y')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Fecha Vencimiento:
                                    </label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input id="vencimiento" name="fecha_vencimiento"
                                               value="{{$fecha_vencimiento}}"
                                               class="date-picker form-control col-md-7 col-xs-12"
                                               placeholder="00/00/0000">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="precio" class="control-label col-md-4 col-sm-3 col-xs-12">Precio:
                                        <span class="required">*</span></label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input name="precio" type="number" class="form-control col-md-7 col-xs-12"
                                               placeholder="0.00" step="0.01" required
                                               value="{{$activo? $activo->precio:old('precio')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Ubicación:<span
                                                class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input name="ubicacion" class="form-control col-md-7 col-xs-12"
                                               placeholder="¿Donde se encuentra?" required
                                               value="{{$activo? $activo->ubicacion:old('ubicacion')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Cantidad mínima:
                                    </label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="number" name="cantidad_minima" placeholder="0"
                                               class="form-control col-md-7 col-xs-12" required
                                               value="{{$inventario? $inventario->cantidad_minima:0}}" min="0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Cantidad máxima:
                                    </label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="number" name="cantidad_maxima" placeholder="0"
                                               class="form-control col-md-7 col-xs-12" required
                                               value="{{$inventario? $inventario->cantidad_maxima:100}}" min="0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Número de lote:
                                        <span class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input name="num_lote" class="form-control col-md-7 col-xs-12"
                                               placeholder="######"
                                               value="{{$activo? $activo->num_lote:old('num_lote')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sucursal_id" class="control-label col-md-4 col-sm-3 col-xs-12">Sucursal:
                                    </label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <select id="sucursal_id" name="sucursal_id" class="form-control"
                                                style="width: 100%">
                                            @foreach($sucursales as $sucursal)
                                                <option value="{{$sucursal->id}}"
                                                        @if($activo&&$sucursal->id==$activo->sucursal_id) selected
                                                        @endif>{{$sucursal->display_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="estado_id" class="control-label col-md-4 col-sm-3 col-xs-12">Estado:
                                    </label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <select id="estado_id" name="estado_id" class="form-control"
                                                style="width: 100%">
                                            @foreach($estados as $estado)
                                                <option value="{{$estado->id}}"
                                                        @if($activo&&$estado->id==$activo->estado_id) selected
                                                        @endif>{{$estado->display_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        {{--<div class="ln_solid"></div>--}}
                        <br><br>
                        <div class="form-group col-md-12" style="margin-top: 30px">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                                <button type="reset" class="btn btn-dark">Reestablecer</button>
                                <button class="btn btn-success">Actualizar</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{url('gentallela/js/moment/moment.min.js')}}"></script>
    <script src="{{url('gentallela/js/datepicker/daterangepicker.js')}}"></script>
    <script src="{{url('gentallela/vendors/select2/dist/js/select2.full.min.js')}}"></script>
@endsection
@section('script-codigo')
    <script>
        $(document).ready(function () {
            $('#birthday').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                singleDatePicker: true,
                showDropdowns: true
            });
            $('#vencimiento').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                singleDatePicker: true,
                showDropdowns: true
            });
            $("#sucursal_id").select2({
                placeholder: "Seleccione una sucursal...",
                allowClear: true
            });
            $("#estado_id").select2({
                placeholder: "Seleccione un estado...",
                allowClear: true
            });
        });
    </script>
@endsection
