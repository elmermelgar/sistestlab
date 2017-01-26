@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentallela/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/inicio')}}">
                    <span class="fa fa-home"></span>
                </a></li>
            <li>Inventario</li>
            <li>Activos</li>
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

            <div class="col-md-12">
                @include('flash::message')
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h3>Activos
                                <a href="{{route('activo.create')}}" title="Crear Nuevo Activo" style="float: right">
                                    <div class="btn btn-success">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Nuevo Activo
                                    </div>
                                </a>
                                <ul class="nav navbar-right panel_toolbox" style="margin-right: 30px">
                                    <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                            </h3>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Fecha de Adq</th>
                                    <th>Precio</th>
                                    <th># de Lote</th>
                                    <th>Ubicacion</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Serie</th>
                                    <th>Unidades</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach($activos as $activo)
                                    <tr>
                                        <td>{{$activo->nombre_activo}}</td>
                                        <td>{{$activo->fecha_adq}}</td>
                                        <td>${{$activo->precio}}</td>
                                        <td>{{$activo->num_lote}}</td>
                                        <td>{{$activo->ubicacion}}</td>
                                        <td>{{$activo->marca}}</td>
                                        <td>{{$activo->modelo}}</td>
                                        <td>{{$activo->serie}}</td>
                                        <td>{{$activo->unidades}}</td>
                                        <td style="text-align: center">
                                            <a href="{{route('activo.edit',$activo->id)}}" class="btn btn-warning" title="Editar Activo">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{route('activo.show',$activo->id)}}" style="background: #20b426" class="btn btn-dark" title="Ver Activo">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                            {{--<a href="{{route('activo.destroy',$activo->id)}}" onclick="return confirm('Seguro')" class="btn btn-danger" title="Eliminar Activo">--}}
                                                {{--<i class="fa fa-university" aria-hidden="true"></i>--}}
                                            {{--</a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>
<script>
    $('#flash-overlay-modal').modal();
</script>
@endsection
