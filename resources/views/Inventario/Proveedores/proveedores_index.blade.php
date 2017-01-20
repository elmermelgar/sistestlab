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
                            <h3>Proveedores
                                <a href="{{route('proveedores.create')}}" title="Crear Nuevo Proveedor" style="float: right">
                                    <div class="btn btn-success">
                                        <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Proveedor
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

                            <table id="datatable" class="table table-striped table-bordered">
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
                                            <a href="{{route('proveedores.edit',$proveedor->id)}}" class="btn btn-warning" title="Editar Proveedor">
                                                <i class="fa fa-cogs" aria-hidden="true"></i>
                                            </a>
                                                    <a href="{{route('proveedores.destroy',$proveedor->id)}}" class="btn btn-danger" title="Eliminar Proveedor">
                                                        <i class="fa fa-university" aria-hidden="true"></i>
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
    $(document).ready(function() {

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
            keys: true
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
