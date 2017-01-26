@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentallela/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    @endsection

@section('content')
    <div class="page-title">
        <div class="title_left">
            <ol class="breadcrumb">
                <li><a href="{{ url('/inicio')}}">
                        <span class="fa fa-home"></span>
                    </a></li>
                <li><a href="{{ route('activo.index')}}">Activo
                    </a></li>
                <li>Detalle de activo</li>
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

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <div class="clearfix"></div>
    <div  class="row">


        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Detalles de {{$activo->nombre_activo}}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="http://www.arkisoft.net/Admin/Modules/Pages/archives/boxes%20copy_thumb.png" class="img-circle img-responsive"> </div>

                    <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                      <dl>
                        <dt>DEPARTMENT:</dt>
                        <dd>Administrator</dd>
                        <dt>HIRE DATE</dt>
                        <dd>11/12/2013</dd>
                        <dt>DATE OF BIRTH</dt>
                           <dd>11/12/2013</dd>
                        <dt>GENDER</dt>
                        <dd>Male</dd>
                      </dl>
                    </div>-->
                    <div class=" col-md-8 col-lg-8 ">
                        <table class="table table-user-information" style="font-size: 16px; font-family: Source Serif Pro, PT Sans, Trebuchet MS, Helvetica, Arial">
                            <tbody>
                            <tr>
                                <td><b>Nombre:</b></td>
                                <td>{{$activo->nombre_activo}}</td>
                            </tr>
                            <tr>
                                <td><b>Codigo de Inventario:</b></td>
                                <td>{{$activo->cod_inventario}}</td>
                            </tr>
                            <tr>
                                <td><b>Fecha de Adquicisión:</b></td>
                                <td>{{$activo->fecha_adq}}</td>
                            </tr>
                            <tr>
                                <td><b>Precio:</b></td>
                                <td>$ {{$activo->precio}}</td>
                            </tr>
                            <tr>
                                <td><b>Ubicación:</b></td>
                                <td>{{$activo->ubicacion}}</td>
                            </tr>
                            <tr>
                                <td><b>Tipo:</b></td>
                                <td>{{$activo->tipo}}</td>
                            </tr>
                            <tr>
                                <td><b>Numero de lote:</b></td>
                                <td>{{$activo->num_lote}}</td>
                            </tr>
                            <tr>
                                <td><b>Marca:</b></td>
                                <td>{{$activo->marca}}</td>
                            </tr>
                            <tr>
                                <td><b>Modelo:</b></td>
                                <td>{{$activo->modelo}}</td>
                            </tr>
                            <tr>
                                <td><b>Serie:</b></td>
                                <td>{{$activo->serie}}</td>
                            </tr>
                            <tr>
                                <td><b>Unidades:</b></td>
                                <td>{{$activo->unidades}}</td>
                            </tr>
                            <tr>
                                <td>INVENTARIO</td>
                                <td><a href="#">----------------</a></td>
                            </tr>
                            <tr>
                                <td><b>Existencia:</b></td>
                                <td>{{$inventario->existencia}}</td>
                            </tr>
                            <tr>
                                <td><b>Cantidad mínima:</b></td>
                                <td>{{$inventario->cantidad_minima}}</td>
                            </tr>
                            <tr>
                                <td><b>Cantidad máxima:</b></td>
                                <td>{{$inventario->cantidad_maxima}}</td>
                            </tr>
                            <tr>
                                <td><b>Fecha cargado:</b></td>
                                <td>{{$inventario->fecha_cargado}}</td>
                            </tr>
                            <tr>
                                <td><b>Fecha de Vencimiento:</b></td>
                                <td>{{$inventario->fecha_vencimiento}}</td>
                            </tr>
                            </tbody>
                        </table>

                        <button  class="btn btn-round btn-success" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-upload" aria-hidden="true"> </i> Cargar Inventario</button>
                        <a href="{{route('activo.editinventario',[$inventario->id,$activo->id])}}" style="float: right; " class="btn btn-round btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Inventario</a>
                    </div>
                    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel2">Cargar Existencias</h4>
                                </div>
                                <form class="form-horizontal form-label-left" action="{{route('cargar.updateinventario',[$inventario->id,$activo->id])}}" method="POST">
                                    {{ csrf_field() }}
                                <div class="modal-body">

                                        {{--Parte 1--}}
                                        <fieldset>
                                            <legend class="text-danger" style="text-align: center">{{$activo->nombre_activo}}</legend>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-3 col-xs-12" >Cantidad a cargar:
                                                    </label>
                                                    <br/>

                                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                                        <input type="number" name="cantidad" placeholder="0"
                                                               class="form-control col-md-7 col-xs-12" min="1" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 col-sm-3 col-xs-12" >Fecha Vencimiento:
                                                    </label>
                                                    <br/>

                                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                                        <input type="text" id="vencimiento" name="fecha_vencimiento" class="date-picker form-control col-md-7 col-xs-12" placeholder="00/00/0000">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Cargar al inventario</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{url('gentallela/js/moment/moment.min.js')}}"></script>
    <script src="{{url('gentallela/js/datepicker/daterangepicker.js')}}"></script>
    @endsection
@section('script-codigo')
<script>
    $(document).ready(function() {
        var handleDataTableButtons = function() {
            if ($("#datatable-buttons").length) {
                $("#datatable-buttons").DataTable({
                    dom: "Bfrtip",
                    buttons: [
                        {
                            extend: "copy",
                            className: "btn-sm"
                        },
                        {
                            extend: "csv",
                            className: "btn-sm"
                        },
                        {
                            extend: "excel",
                            className: "btn-sm"
                        },
                        {
                            extend: "pdfHtml5",
                            className: "btn-sm"
                        },
                        {
                            extend: "print",
                            className: "btn-sm"
                        },
                    ],
                    responsive: true
                });
            }
        };

        TableManageButtons = function() {
            "use strict";
            return {
                init: function() {
                    handleDataTableButtons();
                }
            };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
            keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
            ajax: "js/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
            fixedHeader: true
        });

        TableManageButtons.init();
    });
</script>
<script>
    $(document).ready(function() {
        $('#vencimiento').daterangepicker({
            singleDatePicker: true,
            calender_style: "picker_4"
        }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>
<script>
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>
<script>
    $('#flash-overlay-modal').modal();
</script>
@endsection
