@extends('layouts.app')

@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url("/css/sumoselect.css")}}">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/perfiles')}}">Perfiles</a></li>
            <li>{{$perfil? $perfil->display_name:'Nuevo'}}</li>
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

            @if($perfil)
                <h2>Editar Perfil</h2>
            @else
                <h2>Registrar Perfil</h2>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{url('perfiles/store')}}"
                  enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="col-md-8 col-sm-8 col-xs-12 col-sm-offset-1">

                    <div class="form-group hidden">
                        <label for="profile_id" class="control-label col-md-4 col-sm-4 col-xs-12"> Id
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="profile_id" name="profile_id" class="form-control" placeholder="ID"
                                   value="{{$perfil? $perfil->id:old('profile_id')}}" @if($perfil) required @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="control-label col-md-4 col-sm-4 col-xs-12">Tipo</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="radio" id="type" name="type" class="custom-check"
                                   value="1" @if($perfil? $perfil->type:true) checked @endif>
                            Grupo <br>
                            <input type="radio" id="type" name="type" class="custom-check"
                                   value="0" @if($perfil? !$perfil->type:null) checked @endif disabled>
                            Examen <br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-md-4 col-sm-4 col-xs-12"> Código/Nombre
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="name" name="name" class="form-control" placeholder="nombre"
                                   maxlength="255" value="{{$perfil? $perfil->name:old('name')}}"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="display_name" class="control-label col-md-4 col-sm-4 col-xs-12"> Nombre para mostrar
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="display_name" name="display_name" class="form-control"
                                   placeholder="Nombre para mostrar"
                                   maxlength="255" value="{{$perfil? $perfil->display_name:old('display_name')}}"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="control-label col-md-4 col-sm-4 col-xs-12"> Descripción
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea id="description" name="description" class="form-control"
                                      placeholder="Descripción" maxlength="255"
                            >{{$perfil? $perfil->description:old('description')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="enabled" class="control-label col-md-4 col-sm-4 col-xs-12">Habilitar</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="checkbox" id="enabled" name="enabled" class="custom-check"
                                   @if($perfil? $perfil->enabled:true) checked @endif>
                        </div>
                    </div>

                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="ln_solid"></div>
                    <div class="form-group">

                        <div class="col-md-offset-4 col-md-2 col-sm-2 col-xs-12">
                            <a href="{{url()->previous()}}" class="form-control btn btn-default">Cancelar</a>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <input type="submit" class="form-control btn btn-primary" value="Guardar">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection

@section('scripts')

@endsection