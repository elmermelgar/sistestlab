@extends('layouts.app')

@section('imports')

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            @if(Auth::user()->can('admin_clientes'))
                <li><a href="{{url('/clientes')}}">Clientes</a></li>
            @endif
            <li>{{$cliente->razon_social}}</li>
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

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h3>Cliente {{$cliente->razon_social}}</h3>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-6 col-sm-6 col-xs-12 profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <!-- Current avatar -->
                            <img class="img-responsive avatar-view" alt="Avatar" title="Change the avatar"
                                 style="max-height: 200px"
                                 src="
                            @if($cliente->user->photo)
                                 {{url('/storage/photos/'.$cliente->user->photo)}}
                                 @else
                                 {{url('/storage/photos/'. 'user.png')}}
                                 @endif ">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h4>{{$cliente->razon_social}}</h4>

                    <ul class="list-unstyled user_data">

                        <li>
                            <i class="fa fa-briefcase user-profile-icon"></i>
                            @forelse($cliente->user->roles as $rol)
                                {{$rol->display_name}}
                                @if(!$loop->last)
                                    {{', '}}
                                @endif
                            @empty
                                Sin roles!
                            @endforelse
                        </li>

                        <li class="m-top-xs">
                            <i class="fa fa-envelope user-profile-icon"></i>
                            {{$cliente->user->email}}
                        </li>
                        <li><i class="fa fa-phone user-profile-icon"></i>
                            Telefono: <strong>{{$cliente->telefono}}</strong>
                        </li>
                        <li><i class="fa fa-bank user-profile-icon"></i>
                            Dirección: <strong>{{$cliente->direccion}}</strong>
                        </li>
                        <li><i class="fa fa-calendar user-profile-icon"></i>
                            Registrado en: <strong>{{$cliente->created_at}}</strong>
                        </li>
                    </ul>

                    <a class="btn btn-primary" href="
            @if(Auth::user()->can('admin_clientes'))
                    {{url('clientes/'.$cliente->id.'/edit')}}
                    @else
                    {{url('cliente/editar/')}}
                    @endif "><i class="fa fa-edit m-right-xs"></i>Editar Cliente</a>
                    <br/>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h4>Usuario</h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Email</th>
                        <td>{{$cliente->user->email}}</td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            @if($cliente->user->enabled) <span class="badge bg-green">Habilitado</span>
                            @else <span class="badge bg-red">Deshabilitado</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Ultimo Acceso</th>
                        <td>{{($cliente->user->last_login)?:'--'}}</td>
                    </tr>
                    </tbody>
                </table>

                @permission('admin_users')

                <form method="post" action="
                @if($cliente->user->enabled) {{url('usuarios/disable')}}
                @else {{url('usuarios/enable')}}
                @endif">
                    {{csrf_field()}}

                    <div class="form-group hidden">
                        <label for="user_id">ID</label>
                        <input id="user_id" name="user_id" value="{{$cliente->user->id}}">
                    </div>

                    @if($cliente->user->enabled)
                        <input type="submit" value="Deshabilitar" class="btn btn-danger">
                    @else
                        <input type="submit" value="Habilitar" class="btn btn-success">
                    @endif

                </form>

                @endpermission

            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h2>Pacientes</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h4>A este cliente se han asociado los siguientes pacientes:</h4>

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
                    @forelse($cliente->pacientes as $paciente)
                        <tr>
                            <td>{{$paciente->documento_identidad
                            }}</td>
                            <td>{{$paciente->getFullName()}}</td>
                            <td>{{$paciente->fecha_nacimiento}}</td>
                            <td>
                                <a class="btn btn-info btn-xs" title="Ver Paciente"
                                   href="{{ url('pacientes/' . $paciente->id) }}">
                                    <i class="fa fa-eye"></i> Ver Paciente
                                </a>
                            </td>
                        </tr>
                    @empty
                        <td colspan="4">Sin pacientes asociados!</td>
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
@endsection