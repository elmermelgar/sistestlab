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
            <li><a href="{{url('/usuarios')}}">Usuarios</a></li>
            <li>{{$user?$user->getFullName():'Nuevo'}}</li>
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

            @if($user)
                <h2>Editar Usuario</h2>
            @else
                <h2>Nuevo Usuario</h2>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{url('usuarios/store')}}"
                  enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <!-- Current avatar -->
                            <img class="img-responsive avatar-view" alt="Avatar" title="Change the avatar"
                                 style="max-height: 200px"
                                 src="
                            @if($user? $user->photo:null)
                                 {{url('/storage/photos/'.$user->photo)}}
                                 @else
                                 {{url('/storage/photos/'. 'user.png')}}
                                 @endif
                                         ">

                            <br>
                            <label for="avatar" id="labelAvatar" class="btn btn-success" style="margin-bottom: 1em">
                                Cambiar Foto
                            </label>
                            <input type="file" id="avatar" name="avatar" maxlength="255" accept=".png,.jpg,.jpeg"
                                   style="display: none">
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group hidden">
                        <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12"> Id
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$user? $user->id:old('id')}}" @if($user) required @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12"> Nombre
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" name="name" class="form-control" placeholder="Nombre"
                                   value="{{$user? $user->name:old('name')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="surname" class="control-label col-md-3 col-sm-3 col-xs-12"> Apellido
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="surname" name="surname" class="form-control" placeholder="Apellido"
                                   value="{{$user? $user->surname:old('surname')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12"> Email
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                   value="{{$user? $user->email:old('email')}}" required @if($user) readonly @endif>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sucursal_id" class="control-label col-md-3 col-sm-3 col-xs-12"> Sucursal
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            @if(Auth::user()->can('admin_users'))
                                <select id="sucursal_id" name="sucursal_id" class="sucursal form-control" required>
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{$sucursal->id}}"
                                                @if($user?$user->sucursal->name:null==$sucursal->name) selected @endif>
                                            {{$sucursal->display_name}}</option>
                                    @endforeach
                                </select>
                            @else
                                <input id="sucursal" name="sucursal" class="form-control" placeholder="Surcursal"
                                       value="{{$user? $user->sucursal->display_name:null}}" required readonly>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="roles" class="control-label col-md-3 col-sm-3 col-xs-12"> Roles
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            @if(Auth::user()->can('admin_users'))
                                <select id="roles" name="roles[]" class="role form-control" multiple>
                                    @foreach($roles as $rol)
                                        <option value="{{$rol->id}}"
                                                @if($user? $user->hasRole($rol->name):null) selected @endif>
                                            {{$rol->display_name}}</option>
                                    @endforeach
                                </select>
                            @else
                                <input id="role" name="role" class="form-control" placeholder="Roles"
                                       value="
                                        @forelse($user->roles as $rol)
                                       {{$rol->display_name}}
                                       @if(!$loop->last)
                                       {{', '}}
                                       @endif
                                       @empty
                                               Sin roles!
                                           @endforelse " readonly>
                            @endif
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">

                        <div class="col-md-offset-3 col-md-3">
                            <a href="{{url()->previous()}}" class="form-control btn btn-default">Cancelar</a>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="form-control btn btn-primary" value="Guardar">
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('/js/avatar.js')}}"></script>
    <script src="{{url("/js/sumoselect.min.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('.sucursal').SumoSelect({placeholder: 'Seleccione la sucursal a asignar'});
            $('.role').SumoSelect({placeholder: 'Seleccione los roles a asignar'});
        });
    </script>
@endsection