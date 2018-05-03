@extends('layouts.app')
@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url("/css/sumoselect.css")}}">
@endsection
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

            <div class="col-md-12   ">

                <form class="form-horizontal form-label-left" method="post" action="{{url('sucursales/store')}}" enctype="multipart/form-data">
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
                    <div class="col-md-8">
                    <div class="form-group">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="name" name="name" class="form-control" placeholder="nombre_de_sucursal"
                                   maxlength="255" value="{{$sucursal? $sucursal->name:null}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="display_name" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre para mostrar
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="display_name" name="display_name" class="form-control" maxlength="255"
                                   placeholder="Nombre para Mostrar"
                                   value="{{$sucursal? $sucursal->display_name:old('display_name')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input id="telefono" name="telefono" class="form-control"
                                   placeholder="Telefono" maxlength="8"
                                   value="{{$sucursal? $sucursal->telefono:old('telefono')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="control-label col-md-3 col-sm-3 col-xs-12">Dirección
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea id="direccion" name="direccion" class="form-control" rows="3" maxlength="255"
                                      placeholder="Dirección">{{$sucursal? $sucursal->direccion:old('direccion')}}</textarea>
                        </div>
                    </div>
                </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="profile_img">
                            <div id="crop-seal">
                                <!-- Current avatar -->
                                <img class="img-responsive seal-view" alt="Seal" title="Change the seal"
                                     style="max-height: 200px"
                                     src="
                            @if($sucursal? $sucursal->seal:null)
                                     {{url('/storage/seals/'.$sucursal->seal)}}
                                     @else
                                     {{url('/storage/seals/'. 'seal.png')}}
                                     @endif ">
                                <br>
                                <label for="seal" id="labelSeal" class="btn btn-success" style="margin-bottom: 1em">
                                    Cambiar Sello
                                </label>
                                <input type="file" id="seal" name="seal" maxlength="255" accept=".png,.jpg,.jpeg"
                                       style="display: none">
                                <p>*Resolución recomendada: 400x200</p>
                            </div>
                        </div>
                    </div>



                    {{--<div class="ln_solid"></div>--}}
                    <div class="form-group">
                        <a href="{{url()->previous()}}" class="col-md-4 col-sm-6 col-xs-12 col-md-offset-1">
                            <div class="form-control btn btn-default ">Cancelar</div>
                        </a>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input type="submit" class="form-control btn btn-primary" value="Guardar">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{url('/js/seal.js')}}"></script>
@endsection