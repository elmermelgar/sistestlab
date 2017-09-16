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
            <li>Recolector</li>
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
                    <h3>Sucursales</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="POST" action="{{route('report.recolector')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="recolector_id">Recolector</label>
                            <select id="recolector_id" name="recolector_id" class="form-control" required>
                                @foreach($recolectores as $recolector)
                                    <option value="{{$recolector->id}}">{{$recolector->name()}}</option>
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
            $('#recolector_id').SumoSelect({
                search: true,
                placeholder: 'Seleccione al mensajero',
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