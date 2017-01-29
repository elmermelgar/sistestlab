@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/inicio')}}">
                    <span class="fa fa-home"></span>
                </a></li>
            <li>Usuarios</li>
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
            <h1>Usuarios
                <a href="{{ url('usuarios/create') }}" title="Crear Nuevo Usuario" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Usuario
                    </div>
                </a>
            </h1>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table">
                <table class="table table-striped" id="datatable">
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">Id</th>
                        <th data-field="name" data-sortable="true">Nombre</th>
                        <th data-field="surname" data-sortable="true">Apellido</th>
                        <th data-field="email" data-sortable="true">Email</th>
                        <th data-field="sucursal" data-sortable="true">Sucursal</th>
                        <th data-field="last_login" data-sortable="true">Ultimo Acceso</th>
                        <th data-field="actions" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->surname}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->sucursal->display_name}}</td>
                            <td>{{$user->last_login}}</td>
                            <td>
                                <a href="{{ url('usuarios/show/'.$user->id )}}"
                                   class="btn btn-success btn-sm" title="Ver Usuario"><span
                                            class="fa fa-eye"></span></a>
                                <a href="{{ url('usuarios/edit/' . $user->id )  }}"
                                   class="btn btn-primary btn-sm" title="Editar Usuario"><span
                                            class="fa fa-edit"></span></a>
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