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
                        <label for="sucursal_id" class="control-label col-md-3 col-sm-3 col-xs-12"> Sucursal
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="sucursal_id" name="sucursal_id" class="sucursal form-control" required>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{$sucursal->id}}"
                                            @if($paciente? $paciente->account->sucursal_id==$sucursal->id:null)
                                            selected
                                            @endif>
                                        {{$sucursal->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="identity_document" class="control-label col-md-3 col-sm-3 col-xs-12">DUI
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="identity_document" name="identity_document" class="form-control"
                                   placeholder="DUI"
                                   value="{{$paciente? $paciente->identity_document:old('identity_document')}}"
                                   maxlength="10" pattern="[0-9]{8}-([0-9])" title="Formato: 00000000-0"
                                   data-inputmask="'mask': '99999999-9'">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="first_name" name="first_name" class="form-control" placeholder="Nombre"
                                   value="{{$paciente? $paciente->first_name:old('first_name')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="control-label col-md-3 col-sm-3 col-xs-12">Apellido
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="last_name" name="last_name" class="form-control" placeholder="Apellido"
                                   value="{{$paciente? $paciente->last_name:old('last_name')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sex" class="control-label col-md-3 col-sm-3 col-xs-12"> Sexo
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="sex" name="sex" class="form-control" required>
                                <option value="M"
                                        @if($paciente? $paciente->sex=="M":null) selected @endif>Masculino
                                </option>
                                <option value="F"
                                        @if($paciente? $paciente->sex=="F":null) selected @endif>Femenino
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birth_date" class="control-label col-md-3 col-sm-3 col-xs-12"> Fecha de
                            nacimiento
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="birth_date" name="birth_date" class="form-control has-feedback-left"
                                   placeholder="Fecha de nacimiento" required
                                   value="{{$paciente? $paciente->birth_date:old('birth_date')}}">
                            <i class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="customer_id" class="control-label col-md-3 col-sm-3 col-xs-12"> Cliente
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select multiple id="customer_id" name="customer_id[]" class="form-control" required>
                                @foreach($clientes as $cliente)
                                    <option value="{{$cliente->id}}"
                                            @if($paciente? $paciente->customers->find($cliente->id):null) selected
                                            @endif>{{$cliente->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone_number" class="control-label col-md-3 col-sm-3 col-xs-12"> Teléfono
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="phone_number" name="phone_number" class="form-control" placeholder="Teléfono"
                                   required data-inputmask="'mask': '9999-9999'"
                                   value="{{$paciente? $paciente->phone_number:old('phone_number')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12"> Dirección
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="address" name="address" class="form-control resize"
                                      placeholder="Dirección"
                            >{{$paciente? $paciente->address:old('address')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="profession" class="control-label col-md-3 col-sm-3 col-xs-12"> Profesión
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="profession" name="profession" class="form-control" placeholder="Profesión"
                                   value="{{$paciente? $paciente->profession:old('profession')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comment" class="control-label col-md-3 col-sm-3 col-xs-12"> Observación
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="comment" name="comment" class="form-control resize" placeholder="Observación"
                            >{{$paciente? $paciente->comment:old('comment')}}</textarea>
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
    <script src="{{url('js/moment-with-locales.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{url('gentallela/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{url('js/paciente.js')}}"></script>
@endsection