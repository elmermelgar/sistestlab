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
            <li>Admin</li>
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
            <h1>Usuarios</h1>
            <a href="{{ url('/admin/usuarios/create') }}" title="Crear Nuevo Usuario" style="float: right">
                <div class="btn btn-primary">
                    <span class="fa fa-user-plus" aria-hidden="true"></span> Nuevo Usuario
                </div>
            </a>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table">
                <table class="table table-striped table-bordered" id="datatable">
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">Id</th>
                        <th data-field="nombre" data-sortable="true">Nombre</th>
                        <th data-field="email" data-sortable="true">Email</th>
                        <th data-field="roles" data-sortable="true">Roles</th>
                        <th data-field="lastaccess" data-sortable="true">Ultimo Acceso</th>
                        <th data-field="actions" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)

                        <tr>
                            <td>{{$user->getAttribute('id')}}</td>
                            <td>{{$user->getAttribute('name')}}</td>
                            <td>{{$user->getAttribute('email')}}</td>
                            <td>
                                <ul>
                                    @forelse ($user->getAttribute('roles') as $rol)
                                        <li>{{ $rol->getAttribute('display_name') }}</li>
                                    @empty
                                        <p>Sin roles</p>
                                    @endforelse
                                </ul>
                            </td>
                            <td>{{$user->getAttribute('updated_at')}}</td>
                            <td>
                                <a href="{{ url('/admin/usuarios/'.$user->getAttribute('id') ) }}"
                                   class="btn btn-success btn-xs" title="Ver Usuario"><span
                                            class="fa fa-eye"></span></a>
                                <a href="{{ url('/admin/usuarios/edit/' . $user->getAttribute('id'))  }}"
                                   class="btn btn-primary btn-xs" title="Editar Usuario"><span
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