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
            <li><a href="{{ route('report') }}">Reportes</a></li>
            <li>Cantidad de prueba específica por sucursal</li>
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

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Cantidad de prueba específica por sucursal</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <p>Cantidad de prueba especifíca por sucursal e ingreso en un rango de fechas.</p>
                    <form method="POST" action="{{route('report.suc_especifica')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="sucursal_id">Sucursal</label>
                            <select id="sucursal_id" name="sucursal_id" class="form-control" required>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{$sucursal->id}}">{{$sucursal->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="profile_id">Perfil o Examen</label>
                            <select id="profile_id" name="profile_id" class="form-control" required>
                                @foreach($profiles as $profile)
                                    <option value="{{$profile->id}}">{{$profile->name.' - '.$profile->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha inicio</label>
                            <input id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha fin</label>
                            <input id="fecha_fin" name="fecha_fin" class="form-control" required>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <button type="submit" formtarget="_blank" class="btn btn-primary" value="">
                                Generar Reporte
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url("/js/sumoselect.min.js")}}"></script>
    <script src="{{url('js/moment-with-locales.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#sucursal_id').SumoSelect({
                search: true,
                placeholder: 'Seleccione una sucursal'
            });
            $('#profile_id').SumoSelect({
                search: true,
                placeholder: 'Seleccione el perfil o examen'
            });
            $('#fecha_inicio').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                singleDatePicker: true,
                showDropdowns: true
            });
            $('#fecha_fin').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                singleDatePicker: true,
                showDropdowns: true
            });
        });
    </script>
@endsection