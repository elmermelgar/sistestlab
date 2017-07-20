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
                                <i class="fa fa-home"></i>
                            </a></li>
                        <li>Inventario</li>
                        <li>Activo</li>
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
                            <h2>Actualizando datos del inventario</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">


                            <form class="form-horizontal form-label-left" action="{{route('activo.updateinventario',[$inventario->id,$activo->id])}}" method="POST">
                                {{ csrf_field() }}
                                {{--Parte 1--}}
                                <fieldset>
                                    <legend class="text-danger">{{$activo->nombre_activo}}</legend>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12" >Existencia:
                                            </label>

                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <input type="number" name="existencia" placeholder="0"
                                                       class="form-control col-md-7 col-xs-12" min="1" value="{{$inventario->existencia}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12" >Fecha Vencimiento:
                                            </label>

                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <input type="text" id="vencimiento" name="fecha_vencimiento" value="{{$fecha_vencimiento}}" class="date-picker form-control col-md-7 col-xs-12" placeholder="00/00/0000">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12" >Cantidad mínima:
                                            </label>

                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <input type="number" name="cantidad_minima" placeholder="0"
                                                       class="form-control col-md-7 col-xs-12" required value="{{$inventario->cantidad_minima}}" min="0">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12" >Cantidad máxima:
                                            </label>

                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <input type="number" name="cantidad_maxima" placeholder="0"
                                                       class="form-control col-md-7 col-xs-12" required value="{{$inventario->cantidad_maxima}}" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                {{--<div class="ln_solid"></div>--}}
                                <br><br>
                                <div class="form-group col-md-12" style="margin-top: 30px">
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                                        <button type="reset" class="btn btn-dark">Reestablecer</button>
                                        <button type="submit" class="btn btn-success">Actualizar</button>
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
        $('#vencimiento').daterangepicker({
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
