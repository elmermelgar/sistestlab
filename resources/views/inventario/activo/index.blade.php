@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <style>
        @media print {
            .no-print, .no-print * {
                display: none !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/inicio')}}">
                    <i class="fa fa-home"></i>
                </a></li>
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
                        <h3 class="alignleft">Activos</h3>
                        <div class="alignright">
                            <ul class="nav navbar-right panel_toolbox">
                                <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <a href="{{route('activo.create')}}" title="Crear Nuevo Activo">
                                <div class="btn btn-success"><i class="fa fa-plus fa-fw"></i>Nuevo Activo</div>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table id="datatable-buttons" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Serie</th>
                                <th>Unidades</th>
                                <th>Proveedor</th>
                                <th data-sortable="false" class="no-print">Acciones</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($activos as $activo)
                                <tr>
                                    <td>{{$activo->codigo()}}</td>
                                    <td>{{$activo->nombre}}</td>
                                    <td>@if($activo->tipo=='reactivo') Recurso @else Mobiliario y Equipo @endif</td>
                                    <td>{{$activo->marca}}</td>
                                    <td>{{$activo->modelo}}</td>
                                    <td>{{$activo->serie}}</td>
                                    <td>{{$activo->unidades}}</td>
                                    <td>{{$activo->proveedor->nombre}}</td>
                                    <td class="no-print">
                                        <a href="{{route('activo.show',$activo->id)}}" style="background: #20b426"
                                           class="btn btn-dark" title="Ver Activo"><i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{route('activo.edit',$activo->id)}}" class="btn btn-warning"
                                           title="Editar Activo"><i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" onclick="eliminar_activo({{$activo->id}})" class="btn btn-danger"
                                           title="Eliminar Activo"><i class="fa fa-times"></i>
                                        </a>
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
    <script src="{{url('gentallela/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
@endsection
@section('script-codigo')
    <script>
        $(document).ready(function () {
            var handleDataTableButtons = function () {
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

            TableManageButtons = function () {
                "use strict";
                return {
                    init: function () {
                        handleDataTableButtons();
                    }
                };
            }();

            TableManageButtons.init();
        });

        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

        $('#flash-overlay-modal').modal();

        function eliminar_activo(id) {
            (new PNotify({
                title: 'Es necesario confirmación',
                text: 'Esta seguro de eliminar el activo?',
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                confirm: {
                    confirm: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                }
            })).get().on('pnotify.confirm', function () {
                location.href = "activo/" + id + "/destroy";
            }).on('pnotify.cancel', function () {
            });
        }
    </script>
@endsection
