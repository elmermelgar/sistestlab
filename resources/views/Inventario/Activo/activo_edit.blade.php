@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentallela/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{url('gentallela/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('content')


        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/inicio')}}">
                                <span class="fa fa-home"></span>
                            </a></li>
                        <li><a href="{{ route('activo.index')}}">Activos
                            </a></li></li>
                        <li>Actualizando un activo</li>
                    </ol>
                </div>

                <div class="title_right">
                    <div class="form-group pull-right">
                        <div class="input-group" style="">
                            <a href="{{route('activo.index')}}" style="float: right;" class="btn btn-danger"><i class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Editando el activo "{{$activo->nombre_activo}}"</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">


                            <form class="form-horizontal form-label-left" action="{{route('activo.update',$activo->id)}}" method="POST">
                                {{ csrf_field() }}
                                {{--Parte 1--}}
                                <fieldset>
                                    <legend>Activo:</legend>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" >Nombre del Activo: <span class="required">*</span>
                                        </label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input type="text" name="nombre_activo" required="required" placeholder="Nombre del Activo"
                                                   class="form-control col-md-7 col-xs-12" value="{{$activo->nombre_activo}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Fecha de Adquicisión: <span class="required">*</span>
                                        </label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input id="birthday" name="fecha_adq"  class="date-picker form-control col-md-7 col-xs-12" placeholder="00/00/0000"
                                                   required="required" type="text" value="{{$activo->fecha_adq}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="middle-name" class="control-label col-md-4 col-sm-3 col-xs-12">Precio: <span class="required">*</span></label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" type="number" placeholder="0.00" step="any"
                                                   name="precio" required value="{{$activo->precio}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="middle-name" class="control-label col-md-4 col-sm-3 col-xs-12">Tipo: <span class="required">*</span> </label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">

                                            <select class="form-control" name="tipo" tabindex="-1">
                                                <option value="Mobiliario y Equipo" @if($activo->tipo=='Mobiliario y Equipo') selected @endif>Moviliario y Equipo</option>
                                                <option value="Reactivo" @if($activo->tipo=='Reactivo') selected @endif>Reactivo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Ubicacion:<span class="required">*</span> </label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" type="text" placeholder="Dirección"
                                                   name="ubicacion" required value="{{$activo->ubicacion}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Proveedor:<span class="required">*</span> </label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <select class="select2_single form-control" style="width: 100%" required name="proveedor_id" tabindex="-1">
                                                @foreach($proveedores as $proveedor)
                                                <option value="{{$proveedor->id}}" @if($proveedor->id=$activo->proveedor_id) selected @endif>{{$proveedor->nombre}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{--Parte 2--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12">Número de lote:
                                                <span class="required">*</span> </label>

                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <input class="form-control col-md-7 col-xs-12" type="text"
                                                       placeholder="######"
                                                       name="num_lote" value="{{$activo->num_lote}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12">Marca: <span
                                                        class="required">*</span>
                                            </label>

                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <input class="date-picker form-control col-md-7 col-xs-12"
                                                       placeholder=""
                                                       required="required" name="marca" type="text"
                                                       value="{{$activo->marca}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12">Modelo:
                                            </label>

                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <input type="text" name="modelo" placeholder="Modelo"
                                                       class="form-control col-md-7 col-xs-12"
                                                       value="{{$activo->modelo}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12">Serie:
                                            </label>

                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <input type="text" name="serie" placeholder="Serie"
                                                       class="form-control col-md-7 col-xs-12"
                                                       value="{{$activo->serie}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12">Unidades:
                                            </label>

                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <input type="text" name="unidades" placeholder="mm/ml/m/gal"
                                                       class="form-control col-md-7 col-xs-12"
                                                       value="{{$activo->unidades}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12">Sucursal:
                                            </label>

                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <select class="select2_sucursal form-control" style="width: 100%"
                                                        name="sucursal_id" tabindex="-1">
                                                    @foreach($sucursales as $sucursal)
                                                        <option value="{{$sucursal->id}}"
                                                                @if($sucursal->id=$activo->sucursal_id) selected @endif>{{$sucursal->display_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12">Estado:
                                            </label>

                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <select class="select2_estado form-control" style="width: 100%"
                                                        name="estado_id" tabindex="-1">
                                                    @foreach($estados as $estado)
                                                        <option value="{{$estado->id}}"
                                                                @if($estado->id=$activo->estado_id) selected @endif>{{$estado->display_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                {{--<div class="ln_solid"></div>--}}
                                <br><br>
                                <div class="form-group col-md-12" style="margin-top: 20px">
                                    <div class="col-md-12" style="text-align: center">
                                        <button type="reset" class="btn btn-dark">Reestablecer</button>
                                        <button style="width: 120px" type="submit" class="btn btn-success">Actualizar</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection
@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{url('gentallela/js/moment/moment.min.js')}}"></script>
    <script src="{{url('gentallela/js/datepicker/daterangepicker.js')}}"></script>
    <!-- Select2 -->
    <script src="{{url('gentallela/vendors/select2/dist/js/select2.full.min.js')}}"></script>
    @endsection
@section('script-codigo')
<script>
    $(document).ready(function() {

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
            keys: true
        });

    });
</script>
<!-- bootstrap-daterangepicker -->
<script>
    $(document).ready(function() {
        $('#birthday').daterangepicker({
            singleDatePicker: true,
            calender_style: "picker_4"
        }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>
<!-- /bootstrap-daterangepicker -->
<!-- Select2 -->
<script>
    $(document).ready(function() {
        $(".select2_single").select2({
            placeholder: "Seleccione un proveedor...",
            allowClear: true
        });
        $(".select2_sucursal").select2({
            placeholder: "Seleccione una sucursal...",
            allowClear: true
        });
        $(".select2_estado").select2({
            placeholder: "Seleccione un estado...",
            allowClear: true
        });
    });
</script>
<!-- /Select2 -->
@endsection
