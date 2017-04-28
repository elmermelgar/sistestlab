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
            <li><a href="{{url('/recolectores')}}">Recolectores</a></li>
            <li>{{$recolector? $recolector->name:'Nuevo'}}</li>
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

            @if($recolector)
                <h2>Editar Recolector</h2>
            @else
                <h2>Registrar Recolector</h2>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{url('recolectores/store')}}">
                {{csrf_field()}}

                <div class="col-md-9 col-sm-9 col-xs-12" style="margin: 0 auto;float: none">
                    <div class="form-group hidden">
                        <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12"> Id
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$recolector? $recolector->id:old('id')}}" @if($recolector) required @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dui" class="control-label col-md-3 col-sm-3 col-xs-12">
                            DUI <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="dui" name="dui" class="form-control" placeholder="DUI"
                                   value="{{$recolector? $recolector->dui:old('dui')}}" maxlength="10"
                                   pattern="[0-9]{8}-([0-9])" title="Formato: 00000000-0"
                                   data-inputmask="'mask': '99999999-9'" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="control-label col-md-3 col-sm-3 col-xs-12"> Nombre
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="nombre" name="nombre" class="form-control" placeholder="Nombre"
                                   value="{{$recolector? $recolector->nombre:old('nombre')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apellido" class="control-label col-md-3 col-sm-3 col-xs-12"> Apellido
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="apellido" name="apellido" class="form-control" placeholder="Apellido"
                                   value="{{$recolector? $recolector->apellido:old('apellido')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nit" class="control-label col-md-3 col-sm-3 col-xs-12"> NIT
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="nit" name="nit" class="form-control" placeholder="NIT"
                                   data-inputmask="'mask': '9999-999999-999-9'"
                                   maxlength="17" value="{{$recolector? $recolector->nit:old('nit')}}" required>
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
        $(document).ready(function () {
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