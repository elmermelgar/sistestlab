@extends('layouts.app')

@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url("/css/sumoselect.css")}}">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/inicio')}}">
                    <i class="fa fa-home"></i>
                </a></li>
            <li><a href="{{url('/roles')}}">Roles</a></li>
            <li>{{$role->display_name}}</li>
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

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h1>{{$role->display_name}}</h1>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">


                <h3>Rol</h3>

                <ul class="list-unstyled user_data">
                    <li><i class="fa fa-map-marker user-profile-icon"></i>
                        Nombre: <strong>{{$role->name}}</strong>
                    </li>
                    <li><i class="fa fa-map-marker user-profile-icon"></i>
                        Nombre para mostrar: <strong>{{$role->display_name}}</strong>
                    </li>
                    <li><i class="fa fa-envelope user-profile-icon"></i>
                        Descripción: <strong>{{$role->description}}</strong>
                    </li>
                    <li><i class="fa fa-envelope user-profile-icon"></i>
                        Creado en: <strong>{{$role->created_at}}</strong>
                    </li>
                    <li><i class="fa fa-envelope user-profile-icon"></i>
                        Actualizado en: <strong>{{$role->updated_at}}</strong>
                    </li>
                </ul>

                <a class="btn btn-primary" href="{{url('roles/edit/'.$role->id)}}"><i
                            class="fa fa-edit m-right-xs"></i> Editar Rol</a>
                <br/>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="x_panel">

            <div class="x_title">
                <h2>Usuarios</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h4>Este rol ha sido asignado a los siguientes usuarios:</h4>

                <table class="table table-striped " id="datatable">
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">Id</th>
                        <th data-field="name" data-sortable="true">Nombre</th>
                        <th data-field="sucursal" data-sortable="true">Sucursal</th>
                        <th data-field="actions" data-sortable="true">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($role->users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->getFullName()}}</td>
                            <td>{{$user->sucursal->display_name}}</td>
                            <td>
                                <a class="btn btn-info btn-xs" title="Ver Usuario"
                                   href="{{ url('usuarios/show/' . $user->getAttribute('id')) }}">
                                    <i class="fa fa-eye"></i> Ver Usuario
                                </a>
                            </td>
                        </tr>
                    @empty
                        <td colspan="4">Sin usuarios!</td>
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="x_panel">

            <div class="x_title">
                <h2>Permisos</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h4>Este rol tiene los siguientes permisos:</h4>

                <ul class="list-unstyled user_data">
                    @forelse($role->perms as $perm)
                        <li>
                            <i class="fa fa-circle user-profile-icon"></i> {{$perm->display_name}}
                        </li>
                    @empty
                        Sin permisos!
                    @endforelse
                </ul>
                <button type="button" class="fa fa-edit btn btn-primary btn-lg" data-toggle="modal"
                        data-target="#myModal">
                    Editar Permisos
                </button>
                <br/>

            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Asignar Permisos</h4>
                </div>
                <form method="post" action="{{url('roles/postPerms/')}}">
                    {{csrf_field()}}

                    <div class="modal-body">

                        <div class="form-group hidden">
                            <label for="id">ID</label>
                            <input id="id" name="id" class="form-control" value="{{$role->id}}">
                        </div>
                        <div class="form-group">
                            <label for="perms">Permisos</label>
                            <select id="perms" name="perms[]" class="perms form-control" multiple>
                                @foreach($perms as $perm)
                                    <option value="{{$perm->id}}"
                                            @if($role->hasPermission($perm->name)) selected @endif>
                                        {{$perm->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="{{url("/js/sumoselect.min.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('.perms').SumoSelect({placeholder: 'Seleccione los permisos a asignar'});
        });
    </script>
@endsection