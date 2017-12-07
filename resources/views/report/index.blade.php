@extends('layouts.app')

@section('imports')

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
            <li>Reportes</li>
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

    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Reportes</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>RPT_MENSAJERIA</td>
                        <td>Mensajerías</td>
                        <td>Cantidad de recolecciones realizadas por mensajero y por centro de origen, ingresos y monto
                            en bonos en un rango de fechas.
                        </td>
                        <td><a href="{{route('report.mensajeria')}}"><i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>RPT_REFERENCIA</td>
                        <td>Laboratorios de referencia</td>
                        <td>Lista de pruebas por laboratorio de referencia e ingresos en un rango de fechas.
                        </td>
                        <td><a href="{{route('report.referencia')}}"><i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>RPT_REF_ESPECIFICA</td>
                        <td>Cantidad de prueba específica</td>
                        <td>Cantidad de prueba especifíca por laboratorio de referencia e ingreso en un rango de fechas.
                        </td>
                        <td><a href="{{route('report.ref.especifica')}}"><i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection