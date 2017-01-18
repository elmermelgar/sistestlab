@extends('layouts.app')

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/inicio')}}">
                    <span class="fa fa-home"></span>
                </a></li>
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
            <h2>Editar Permiso</h2>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            <div class="col-md-6">

                <form class="form-horizontal form-label-left" method="post" action="{{url('permisos/store')}}">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12">ID
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$permission? $permission->id:null}}" readonly required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="name" name="name" class="form-control" placeholder="Nombre"
                                   value="{{$permission? $permission->name:null}}" readonly required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="display_name" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre para mostrar
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="display_name" name="display_name" class="form-control"
                                   placeholder="Nombre para Mostrar"
                                   value="{{$permission? $permission->display_name:null}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">Descripción
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea id="description" name="description" class="form-control" rows="3"
                                      placeholder="Descripción">{{$permission? $permission->description:null}}</textarea>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <a href="{{url()->previous()}}"><div class="btn btn-primary">Cancelar</div></a>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
