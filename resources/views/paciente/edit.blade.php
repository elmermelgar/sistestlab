@extends('layouts.app')

@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url("/css/sumoselect.css")}}">
    <link rel="stylesheet" type="text/css" href="{{url('gentallela/vendors/iCheck/skins/flat/green.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.css')}}">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/pacientes')}}">Pacientes</a></li>
            <li>{{$paciente? $paciente->name:'Nuevo'}}</li>
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

            @if($paciente)
                <h2>Editar Paciente</h2>
            @else
                <h2>Registrar Paciente</h2>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{url('pacientes/store')}}">
                {{csrf_field()}}

                <div class="col-md-9 col-sm-9 col-xs-12" style="margin: 0 auto;float: none">
                    <div class="form-group hidden">
                        <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12"> Id
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$paciente? $paciente->id:old('id')}}" @if($paciente) required @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="control-label col-md-3 col-sm-3 col-xs-12"> Nombre
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="nombre" name="nombre" class="form-control" placeholder="Nombre"
                                   value="{{$paciente? $paciente->nombre:old('nombre')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apellido" class="control-label col-md-3 col-sm-3 col-xs-12"> Apellido
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="apellido" name="apellido" class="form-control" placeholder="Apellido"
                                   value="{{$paciente? $paciente->apellido:old('apellido')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dui" class="control-label col-md-3 col-sm-3 col-xs-12">
                            DUI
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="dui" name="dui" class="form-control" placeholder="DUI"
                                   value="{{$paciente? $paciente->dui:old('dui')}}" maxlength="10"
                                   pattern="[0-9]{8}-([0-9])" title="Formato: 00000000-0"
                                   data-inputmask="'mask': '99999999-9'">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="genero" class="control-label col-md-3 col-sm-3 col-xs-12"> Género
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="genero" name="genero" class="form-control" required>
                                <option value="Masculino"
                                        @if($paciente? $paciente->genero=="Masculino":null) selected @endif>Masculino
                                </option>
                                <option value="Femenino"
                                        @if($paciente? $paciente->genero=="Femenino":null) selected @endif>Femenino
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento" class="control-label col-md-3 col-sm-3 col-xs-12"> Fecha de
                            nacimiento
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control has-feedback-left" id="fecha_nacimiento" name="fecha_nacimiento"
                                   placeholder="Fecha de nacimiento" required
                                   value="{{$paciente? $paciente->fecha_nacimiento:old('fecha_nacimiento')}}">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cliente_id" class="control-label col-md-3 col-sm-3 col-xs-12"> Cliente
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select multiple id="cliente_id" name="cliente_id[]" class="form-control" required>
                                @foreach($clientes as $cliente)
                                    <option value="{{$cliente->id}}"
                                            @if($paciente? $paciente->clientes->find($cliente->id):null) selected @endif>{{$cliente->razon_social}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12"> Email
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                   value="{{$paciente? $paciente->email:old('email')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="control-label col-md-3 col-sm-3 col-xs-12"> Teléfono
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="telefono" name="telefono" class="form-control" placeholder="Teléfono" required
                                   data-inputmask="'mask': '9999-9999'"
                                   value="{{$paciente? $paciente->telefono:old('telefono')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="direccion" class="control-label col-md-3 col-sm-3 col-xs-12"> Dirección
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="direccion" name="direccion" class="form-control resize"
                                      placeholder="Dirección"
                            >{{$paciente? $paciente->direccion:old('direccion')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="profesion" class="control-label col-md-3 col-sm-3 col-xs-12"> Profesión
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="profesion" name="profesion" class="form-control" placeholder="Profesión"
                                   value="{{$paciente? $paciente->profesion:old('profesion')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="procedencia" class="control-label col-md-3 col-sm-3 col-xs-12"> Procedencia
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="procedencia" name="procedencia" class="form-control" placeholder="Procedencia"
                                   value="{{$paciente? $paciente->procedencia:old('procedencia')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="observacion" class="control-label col-md-3 col-sm-3 col-xs-12"> Observación
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="observacion" name="observacion" class="form-control resize"
                                      placeholder="Observación"
                            >{{$paciente? $paciente->observacion:old('observacion')}}</textarea>
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
    <script src="{{url("/js/sumoselect.min.js")}}"></script>
    <script src="{{url('gentallela/vendors/iCheck/icheck.min.js')}}"></script>
    <script src="{{url('js/moment-with-locales.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script type="application/javascript">
        moment.locale('es');
        $(document).ready(function(){
            $('#cliente_id').SumoSelect({search: true, placeholder: 'Seleccione el cliente a asociar'});
            $('#fecha_nacimiento').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            });
            Inputmask().mask(document.querySelectorAll("input"));
        });
    </script>
    <script src="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
@endsection