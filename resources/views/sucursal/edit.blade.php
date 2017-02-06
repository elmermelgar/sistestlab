@extends('layouts.app')

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('sucursales')}}">Sucursales</a></li>
            <li>{{$sucursal? $sucursal->display_name:'Registrar Sucursal'}}</li>
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
                    Modificar Sucursal
                @else
                    Registrar Sucursal
                @endif
            </h2>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            <div class="col-md-7">

                <form class="form-horizontal form-label-left" method="post" action="{{url('sucursales/store')}}">
                    {{csrf_field()}}

                    @if($sucursal)
                        <div class="form-group hidden">
                            <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12">ID
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="id" name="id" class="form-control" placeholder="ID"
                                       value="{{$sucursal? $sucursal->id:null}}" required readonly>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="name" name="name" class="form-control" placeholder="nombre_de_sucursal"
                                   value="{{$sucursal? $sucursal->name:null}}" required >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="display_name" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre para mostrar
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="display_name" name="display_name" class="form-control"
                                   placeholder="Nombre para Mostrar"
                                   value="{{$sucursal? $sucursal->display_name:old('display_name')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="telefono" name="telefono" class="form-control"
                                   placeholder="Telefono"
                                   value="{{$sucursal? $sucursal->telefono:old('telefono')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="control-label col-md-3 col-sm-3 col-xs-12">Dirección
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea id="direccion" name="direccion" class="form-control" rows="3"
                                      placeholder="Dirección">{{$sucursal? $sucursal->direccion:old('direccion')}}</textarea>
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
