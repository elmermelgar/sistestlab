@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/inicio')}}">
                    <i class="fa fa-home"></i>
                </a></li>
            <li>Inventario</li>
            <li>Proveedores</li>
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

    <div class="">
        <div class="col-md-12">
            @include('flash::message')
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3 class="alignleft">Proveedores</h3>
                        <ul class="nav navbar-right panel_toolbox alignright">
                            <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <a href="{{route('proveedores.create')}}" title="Crear Nuevo Proveedor" class="alignright">
                            <div class="btn btn-success">
                                <i class="fa fa-user-plus"></i> Nuevo Proveedor
                            </div>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table id="datatable" class="table table-striped table-hover table-condensed">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Rubro</th>
                                <th>Email</th>
                                <th>Ubicacion</th>
                                <th>Otros</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($proveedores as $proveedor)
                                <tr>
                                    <td>{{$proveedor->nombre}}</td>
                                    <td>{{$proveedor->telefono}}</td>
                                    <td>{{$proveedor->rubro}}</td>
                                    <td>{{$proveedor->email}}</td>
                                    <td>{{$proveedor->ubicacion}}</td>
                                    <td>{{$proveedor->otros}}</td>
                                    <td style="text-align: center">
                                        <a href="{{route('proveedores.edit',$proveedor->id)}}" class="btn btn-primary"
                                           title="Editar Proveedor">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" onclick="eliminar_proveedor({{$proveedor->id}})"
                                           class="btn btn-danger" title="Eliminar Proveedor">
                                            <i class="fa fa-times" aria-hidden="true"></i>
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
@endsection
@section('script-codigo')
    <script>
        $(document).ready(function () {

            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({
                keys: true
            });

        });

        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

        $('#flash-overlay-modal').modal();

        function eliminar_proveedor(id) {
            (new PNotify({
                title: 'Esta a punto de eliminar un registro',
                text: 'Esta seguro de eliminar el proveedor?',
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
                location.href = "proveedores/" + id + "/destroy";
            }).on('pnotify.cancel', function () {
            });
        }
    </script>
@endsection
