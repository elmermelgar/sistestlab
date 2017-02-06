@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Permisos</li>
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


    <div class="x_panel">

        <div class="x_title">
            <h3>Permisos</h3>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table">
                <table class="table table-striped" id="datatable">
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">Id</th>
                        <th data-field="name" data-sortable="true">Nombre</th>
                        <th data-field="display_name" data-sortable="true">Nombre para Mostrar</th>
                        <th data-field="description" data-sortable="true">Descripción</th>
                        <th data-field="created_at" data-sortable="true">Creado en</th>
                        <th data-field="updated_at" data-sortable="false">Actualizado en</th>
                        <th data-field="actions" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{$permission->getAttribute('id')}}</td>
                            <td>{{$permission->getAttribute('name')}}</td>
                            <td>{{$permission->getAttribute('display_name')}}</td>
                            <td>{{$permission->getAttribute('description')}}</td>
                            <td>{{$permission->getAttribute('created_at')}}</td>
                            <td>{{$permission->getAttribute('updated_at')}}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" title="Editar Usuario"
                                   href="{{ url('permisos/' . $permission->getAttribute('id')).'/edit' }}">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#datatable').dataTable();
        });
    </script>
@endsection