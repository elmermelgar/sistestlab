@extends('layouts.app')

@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url("/css/sumoselect.css")}}">
    <link rel="stylesheet" type="text/css"
          href="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.css')}}">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/clientes')}}">Clientes</a></li>
            <li>{{$cliente? $cliente->razon_social:'Nuevo'}}</li>
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

            @if($cliente)
                <h2>Editar Cliente</h2>
            @else
                <h2>Registrar Cliente</h2>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{url('clientes/store')}}"
                  enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="col-md-8 col-sm-8 col-xs-12 col-sm-offset-1">

                    <div class="form-group hidden">
                        <label for="id" class="control-label col-md-4 col-sm-4 col-xs-12"> Id
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$cliente? $cliente->id:old('id')}}" @if($cliente) required @endif>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="persona_juridica" class="control-label col-md-4 col-sm-4 col-xs-12">Persona</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="radio" id="persona_natural" name="persona_juridica" class="custom-check"
                                   value="false" @if($cliente? !$cliente->persona_juridica:true) checked @endif>
                            Natural <br>
                            <input type="radio" id="persona_juridica" name="persona_juridica" class="custom-check"
                                   value="true" @if($cliente? $cliente->persona_juridica:null) checked @endif>
                            Jurídica <br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="razon_social" class="control-label col-md-4 col-sm-4 col-xs-12"> Razón Social
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="razon_social" name="razon_social" class="form-control" placeholder="Razón Social"
                                   maxlength="255" value="{{$cliente? $cliente->razon_social:old('razon_social')}}"
                                   required>
                        </div>
                    </div>

                    <div id="div_natural" class="hidden">
                        <div class="form-group">
                            <label for="dui" class="control-label col-md-4 col-sm-4 col-xs-12">
                                DUI <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="dui" name="dui" class="form-control" placeholder="DUI"
                                       value="{{$cliente? $cliente->dui:old('dui')}}" maxlength="10"
                                       data-inputmask="'mask': '99999999-9'">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="seguro" class="control-label col-md-4 col-sm-4 col-xs-12"> Seguro</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="seguro" name="seguro" class="form-control" placeholder="Seguro"
                                       maxlength="255" value="{{$paciente? $paciente->seguro:old('seguro')}}">
                            </div>
                        </div>
                    </div>

                    <div id="div_juridica" class="hidden">
                        <div class="form-group">
                            <label for="nit" class="control-label col-md-4 col-sm-4 col-xs-12"> NIT
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="nit" name="nit" class="form-control" placeholder="NIT"
                                       data-inputmask="'mask': '9999-999999-999-9'"
                                       maxlength="17" value="{{$cliente? $cliente->nit:old('nit')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nrc" class="control-label col-md-4 col-sm-4 col-xs-12"> NRC
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="nrc" name="nrc" class="form-control" placeholder="NRC"
                                       data-inputmask="'mask': '999999-9'"
                                       maxlength="8" value="{{$cliente? $cliente->nrc:old('nrc')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="giro" class="control-label col-md-4 col-sm-4 col-xs-12"> Giro
                                <span class="required">*</span></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="giro" name="giro" class="form-control" placeholder="Giro"
                                       maxlength="255" value="{{$cliente? $cliente->giro:old('giro')}}">
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
                                   value="{{$cliente? $cliente->telefono:old('telefono')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-4 col-sm-4 col-xs-12"> Email
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                   maxlength="255"
                                   value=" @if(isset($cliente->user->email)) {{$cliente->user->email}}
                                   @else {{old('email')}}
                                   @endif ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="control-label col-md-4 col-sm-4 col-xs-12"> Dirección</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea id="direccion" name="direccion" class="form-control resize"
                                      placeholder="Dirección"
                                      maxlength="255">{{$cliente? $cliente->direccion:old('direccion')}}</textarea>
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <label for="paciente" class="control-label col-md-4 col-sm-4 col-xs-12">Registrar como
                            paciente</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="checkbox" id="paciente" name="paciente" class="custom-check"
                                   @if($cliente? $cliente->pacientes()->wherePivot('same_record',true)->first():null) checked @endif>
                        </div>
                    </div>

                    <div class="hidden" id="div_paciente">
                        <div class="form-group">
                            <label for="nombre" class="control-label col-md-4 col-sm-4 col-xs-12"> Nombre
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="nombre" name="nombre" class="form-control" placeholder="Nombre"
                                       maxlength="255" value="{{$paciente? $paciente->nombre:old('nombre')}}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="apellido" class="control-label col-md-4 col-sm-4 col-xs-12"> Apellido
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="apellido" name="apellido" class="form-control" placeholder="Apellido"
                                       maxlength="255" value="{{$paciente? $paciente->apellido:old('apellido')}}"
                                       disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="genero" class="control-label col-md-4 col-sm-4 col-xs-12"> Género
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="genero" name="genero" class="form-control" required disabled>
                                    <option value="Masculino"
                                            @if($paciente? $paciente->genero=="Masculino":null) selected @endif>
                                        Masculino
                                    </option>
                                    <option value="Femenino"
                                            @if($paciente? $paciente->genero=="Femenino":null) selected @endif>Femenino
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fecha_nacimiento" class="control-label col-md-4 col-sm-4 col-xs-12"> Fecha de
                                nacimiento
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input class="form-control has-feedback-left" id="fecha_nacimiento"
                                       name="fecha_nacimiento"
                                       placeholder="Fecha de nacimiento" required disabled
                                       value="{{$paciente? $paciente->fecha_nacimiento:old('fecha_nacimiento')}}">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                    </div>

                    <br>

                    <div class="form-group">
                        <label for="user" class="control-label col-md-4 col-sm-4 col-xs-12">Habilitar
                            Usuario</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="checkbox" id="user" name="user" class="custom-check"
                                   @if(isset($cliente->user))
                                   checked
                                    @endif >
                            <i>(Se le enviará un correo electrónico al usuario)</i>
                        </div>
                    </div>

                    <div class="profile_img">
                        <div id="crop-avatar" class="hidden" style="text-align: center">
                            <!-- Current avatar -->
                            <img class="img-responsive avatar-view" alt="Avatar" title="Change the avatar"
                                 style="max-height: 200px; margin: 0 auto"
                                 src="
                            @if(isset($cliente->user->photo))
                                 {{url('/storage/photos/'.$cliente->user->photo)}}
                                 @else
                                 {{url('/storage/photos/user.png')}}
                                 @endif ">

                            <br>
                            <label for="avatar" id="labelAvatar" class="btn btn-success" style="margin-bottom: 1em">
                                Cambiar Imágen
                            </label>
                            <input type="file" id="avatar" name="avatar" maxlength="255" accept=".png,.jpg,.jpeg"
                                   style="display: none">
                            <p>*Resolución recomendada: 200x200</p>
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
    <script src="{{url('/js/avatar.js')}}"></script>
    <script src="{{url('/js/cliente.js')}}"></script>
    <script src="{{url('/js/moment-with-locales.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script type="application/javascript">
        moment.locale('es');
        $(document).ready(function(){
            Inputmask().mask(document.querySelectorAll("input"));
        });
    </script>
    <script src="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
@endsection