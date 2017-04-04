@extends('layouts.app')

@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url("/css/sumoselect.css")}}">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/origenes')}}">Centros de origen</a></li>
            <li>{{$origen? $origen->name:'Nuevo'}}</li>
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

            @if($origen)
                <h2>Editar Centro de Origen</h2>
            @else
                <h2>Registrar Centro de Origen</h2>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{url('origenes/store')}}"
                  enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="col-md-8 col-sm-8 col-xs-12 col-sm-offset-1">

                    <div class="form-group hidden">
                        <label for="id" class="control-label col-md-4 col-sm-4 col-xs-12"> Id
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$origen? $origen->id:old('id')}}" @if($origen) required @endif>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-md-4 col-sm-4 col-xs-12"> Nombre
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="name" name="name" class="form-control" placeholder="nombre_centro_origen"
                                   maxlength="255" required value="{{ $origen? $origen->name:old('name')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="display_name" class="control-label col-md-4 col-sm-4 col-xs-12"> Nombre para mostrar
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="display_name" name="display_name" class="form-control"
                                   placeholder="Nombre del Centro de Origen" maxlength="255" required
                                   value="{{ $origen? $origen->display_name:old('display_name')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-4 col-sm-4 col-xs-12"> Email
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                   maxlength="255" required
                                   value="{{ $origen? $origen->email:old('email')}}">
                        </div>
                    </div>

                    <div id="div_cliente">
                        <div class="form-group hidden">
                            <label for="persona_juridica"
                                   class="control-label col-md-4 col-sm-4 col-xs-12">Persona</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="radio" id="persona_juridica" name="persona_juridica" class="custom-check"
                                       value="true" checked>
                                Jurídica <br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="razon_social" class="control-label col-md-4 col-sm-4 col-xs-12"> Razón Social
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="razon_social" name="razon_social" class="form-control"
                                       placeholder="Razón Social"
                                       maxlength="255" value="{{$origen? $origen->cliente->razon_social:old('razon_social')}}"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nit" class="control-label col-md-4 col-sm-4 col-xs-12"> NIT
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="nit" name="nit" class="form-control" placeholder="NIT"
                                       data-inputmask="'mask': '9999-999999-999-9'"
                                       maxlength="17" value="{{$origen? $origen->cliente->nit:old('nit')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nrc" class="control-label col-md-4 col-sm-4 col-xs-12"> NRC
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="nrc" name="nrc" class="form-control" placeholder="NRC"
                                       data-inputmask="'mask': '999999-9'"
                                       maxlength="8" value="{{$origen? $origen->cliente->nrc:old('nrc')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="giro" class="control-label col-md-4 col-sm-4 col-xs-12"> Giro
                                <span class="required">*</span></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="giro" name="giro" class="form-control" placeholder="Giro"
                                       maxlength="255" value="{{$origen? $origen->cliente->giro:old('giro')}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telefono" class="control-label col-md-4 col-sm-4 col-xs-12"> Teléfono
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="telefono" name="telefono" class="form-control" placeholder="Teléfono"
                                   data-inputmask="'mask': '9999-9999'"
                                   value="{{$origen? $origen->cliente->telefono:old('telefono')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="control-label col-md-4 col-sm-4 col-xs-12"> Dirección</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea id="direccion" name="direccion" class="form-control resize"
                                      placeholder="Dirección"
                                      maxlength="255">{{$origen? $origen->cliente->direccion:old('direccion')}}</textarea>
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
    <script src="{{url('gentallela/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            Inputmask().mask(document.querySelectorAll("input"));
        });
    </script>
@endsection