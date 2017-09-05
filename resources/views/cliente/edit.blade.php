@extends('layouts.app')

@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url("/css/sumoselect.css")}}">
    <link rel="stylesheet" type="text/css"
          href="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.css')}}">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{route('customer')}}">Clientes</a></li>
            <li>{{$cliente? $cliente->razon_social:'Nuevo'}}</li>
        </ol>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
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

            <form class="form-horizontal form-label-left" method="post" action="{{route('customer.store')}}"
                  enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="col-md-8 col-sm-8 col-xs-12 col-sm-offset-1">

                    @if($cliente)
                        <div class="form-group hidden">
                            <label for="id" class="control-label col-md-4 col-sm-4 col-xs-12"> Id
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="hidden" id="id" name="id" class="form-control" placeholder="ID"
                                       value="{{$cliente? $cliente->id:old('id')}}" required readonly>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="sucursal_id" class="control-label col-md-4 col-sm-4 col-xs-12"> Sucursal
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select id="sucursal_id" name="sucursal_id" class="sucursal form-control" required>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{$sucursal->id}}"
                                            @if($cliente? $cliente->account->sucursal_id==$sucursal->id:null)
                                            selected
                                            @endif>
                                        {{$sucursal->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="origin_center" class="control-label col-md-4 col-sm-4 col-xs-12">Registrar como
                            Centro de Origen</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="checkbox" id="origin_center" name="origin_center" class="custom-check"
                                   @if($cliente? $cliente->origin_center:null) checked @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="juridical_person" class="control-label col-md-4 col-sm-4 col-xs-12">Persona</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="radio" id="natural_person" name="juridical_person" class="custom-check"
                                   value="0" @if($cliente? !$cliente->juridical_person:true) checked @endif>
                            Natural <br>
                            <input type="radio" id="juridical_person" name="juridical_person" class="custom-check"
                                   value="1" @if($cliente? $cliente->juridical_person:null) checked @endif>
                            Jurídica <br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-md-4 col-sm-4 col-xs-12"> Razón Social
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="name" name="name" class="form-control" placeholder="Razón Social"
                                   maxlength="255" value="{{$cliente? $cliente->name:old('name')}}"
                                   required>
                        </div>
                    </div>

                    <div id="div_natural" class="hidden">
                        <div class="form-group">
                            <label for="dui" class="control-label col-md-4 col-sm-4 col-xs-12">
                                DUI <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="identity_document" name="identity_document" class="form-control"
                                       placeholder="DUI" maxlength="10" data-inputmask="'mask': '99999999-9'"
                                       value="{{$cliente? $cliente->identity_document:old('identity_document')}}">
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
                            <label for="business" class="control-label col-md-4 col-sm-4 col-xs-12"> Giro
                                <span class="required">*</span></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="business" name="business" class="form-control" placeholder="Giro"
                                       maxlength="255" value="{{$cliente? $cliente->business:old('business')}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="control-label col-md-4 col-sm-4 col-xs-12">Teléfono
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="phone_number" name="phone_number" class="form-control" placeholder="Teléfono"
                                   data-inputmask="'mask': '9999-9999'"
                                   value="{{$cliente? $cliente->phone_number:old('phone_number')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-4 col-sm-4 col-xs-12"> Email
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                   maxlength="255"
                                   value=" @if(isset($cliente->account->user->email)) {{$cliente->account->user->email}}
                                   @else {{old('email')}}
                                   @endif ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label col-md-4 col-sm-4 col-xs-12"> Dirección</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea id="address" name="address" class="form-control resize"
                                      placeholder="Dirección"
                                      maxlength="255">{{$cliente? $cliente->address:old('address')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="control-label col-md-4 col-sm-4 col-xs-12">
                            Descripción/Comentario</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea id="comment" name="comment" class="form-control resize" placeholder="Descripción"
                                      maxlength="255">{{$cliente? $cliente->comment:old('comment')}}</textarea>
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <label for="patient" class="control-label col-md-4 col-sm-4 col-xs-12">Registrar como
                            paciente</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="checkbox" id="patient" name="patient" class="custom-check"
                                   @if($paciente) checked @endif>
                        </div>
                    </div>

                    <div class="hidden" id="div_paciente">
                        <div class="form-group">
                            <label for="first_name" class="control-label col-md-4 col-sm-4 col-xs-12"> Nombre
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="first_name" name="first_name" class="form-control" placeholder="Nombre"
                                       maxlength="255" value="{{$paciente? $paciente->first_name:old('first_name')}}"
                                       disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="control-label col-md-4 col-sm-4 col-xs-12"> Apellido
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="last_name" name="last_name" class="form-control" placeholder="Apellido"
                                       maxlength="255" value="{{$paciente? $paciente->last_name:old('last_name')}}"
                                       disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sex" class="control-label col-md-4 col-sm-4 col-xs-12"> Sexo
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="sex" name="sex" class="form-control" required disabled>
                                    <option value="M"
                                            @if($paciente? $paciente->sexo=="Masculino":null) selected @endif>
                                        Masculino
                                    </option>
                                    <option value="F"
                                            @if($paciente? $paciente->sexo=="Femenino":null) selected @endif>Femenino
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birth_date" class="control-label col-md-4 col-sm-4 col-xs-12"> Fecha de
                                nacimiento
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="birth_date" name="birth_date" class="form-control has-feedback-left"
                                       placeholder="Fecha de nacimiento" required disabled
                                       value="{{$paciente? $paciente->birth_date:old('birth_date')}}">
                                <i class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></i>
                            </div>
                        </div>

                    </div>

                    <br>

                    <div class="form-group">
                        <label for="user" class="control-label col-md-4 col-sm-4 col-xs-12">Habilitar
                            Usuario</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="checkbox" id="user" name="user" class="custom-check"
                                   @if(isset($cliente->account->user))
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
    <script src="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{url('gentallela/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
@endsection