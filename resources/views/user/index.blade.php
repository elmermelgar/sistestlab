@extends('layouts.app')

@section('imports')

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
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
            <h3 class="alignleft">Usuarios</h3>
            <div class="alignright">
                <a href="{{ url('usuarios/create') }}" title="Crear Nuevo Usuario" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-user-plus"></i> Nuevo Usuario
                    </div>
                </a>
            </div>
            <div class="alignright">
                <div class="pull-right top_search" style="margin-right: 5%">
                    <form action="{{ url('usuarios') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="email" placeholder="Buscar por email...">
                            <span class="input-group-btn">
                      <button class="btn btn-default">Buscar</button>
                    </span>
                        </div>
                    </form>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
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
                        <td>{{$user->sucursal? $user->sucursal->display_name:'--'}}</td>
                        <td>{{$user->last_login}}</td>
                        <td>
                            <a href="{{ url('usuarios/'.$user->id )}}"
                               class="btn btn-success btn-sm" title="Ver Usuario">
                                <i class="fa fa-eye"></i></a>
                            <a href="{{ url('usuarios/'. $user->id.'/edit' )  }}"
                               class="btn btn-primary btn-sm" title="Editar Usuario">
                                <i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            <div class="col-md-12" style="text-align: center">
                {{ $users->appends(Request::only(['email']))->render() }}
            </div>
        </div>
    </div>


@endsection

@section('scripts')

@endsection