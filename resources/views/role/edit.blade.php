@extends('layouts.app')

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('roles')}}">Roles</a></li>
            <li>{{$role? $role->display_name:'Nuevo Rol'}}</li>
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
            <h2>
                @if(isset($edit))
                    Editar Rol
                @else
                    Crear Rol
                @endif
            </h2>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            <div class="col-md-7">

                <form class="form-horizontal form-label-left" method="post" action="{{url('roles/store')}}">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12">ID
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$role? $role->id:null}}" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="name" name="name" class="form-control" placeholder="nombre_de_rol"
                                   value="{{$role? $role->name:null}}" required
                                   @if($role? $role->locked:null) readonly @endif >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="display_name" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre para mostrar
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="display_name" name="display_name" class="form-control"
                                   placeholder="Nombre para Mostrar"
                                   value="{{$role? $role->display_name:old('display_name')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">Descripci??n
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea id="description" name="description" class="form-control" rows="3"
                                      placeholder="Descripci??n">{{$role? $role->description:old('description')}}</textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                            <a href="{{url()->previous()}}" class="col-md-4 col-sm-4 col-xs-12 col-md-offset-4">
                                <div class="form-control btn btn-default ">Cancelar</div>
                            </a>
                        <div class="col-md-4 col-sm-3 col-xs-12">
                            <input type="submit" class="form-control btn btn-primary" value="Guardar">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
