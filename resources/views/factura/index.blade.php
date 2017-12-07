@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.css')}}">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Facturas</li>
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
            <h3>Facturas</h3>
            <div class="alignright">
                <a href="{{ route('factura.create') }}" title="Facturar">
                    <div class="btn btn-primary">
                        <i class="fa fa-dollar fa-fw" aria-hidden="true"></i>Nueva Factura
                    </div>
                </a>
                <a href="{{ route('factura.create','origen') }}" title="Facturar">
                    <div class="btn btn-info">
                        <i class="fa fa-dollar fa-fw" aria-hidden="true"></i>Nueva Factura (Centro de Origen)
                    </div>
                </a>
            </div>
            <form class="form-inline" action="{{ url('facturas') }}" method="GET">
                <div class="form-group">
                    <input id="fecha_inicio" name="fecha_inicio" class="form-control" placeholder="Fecha inicio"
                           value="{{ Request::get('fecha_inicio') }}">
                    <input id="fecha_fin" name="fecha_fin" class="form-control" placeholder="Fecha inicio"
                           value="{{ Request::get('fecha_fin') }}">
                    <select id="estado" name="estado" class="form-control">
                        <option value="">Seleccione estado</option>
                        @foreach($estados as $estado)
                            <option value="{{$estado->name}}"
                                    @if($estado->name==Request::get('estado')) selected @endif>
                                {{$estado->display_name}}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control" name="numero" placeholder="Buscar por número..."
                           value="{{ Request::get('numero') }}">
                </div>
                <button type="submit" class="btn btn-default">Buscar</button>
            </form>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <table id="facturas" class="table table-hover">
                <thead>
                <tr>
                    <th data-field="id" data-sortable="false">ID</th>
                    <th data-field="name" data-sortable="true">Número</th>
                    <th data-field="cliente" data-sortable="false">Cliente</th>
                    <th data-field="facturador" data-sortable="false">Facturado por</th>
                    <th data-field="fecha" data-sortable="true">Fecha</th>
                    <th data-field="estado" data-sortable="true">Estado</th>
                    <th data-field="venta" data-sortable="true">Venta (USD)</th>
                    <th data-field="actions" data-sortable="false">Acciones</th>
                </tr>
                </thead>

                <tbody>
                @foreach($facturas as $factura)
                    <tr @if($factura->estado->name=='abierta') class="bg-warning" @endif>
                        <td>{{$factura->id}}</td>
                        <td>{{$factura->numero}}</td>
                        <td>{{$factura->customer->name}}</td>
                        <td>{{$factura->facturador->name()}}</td>
                        <td>{{$factura->date.' '.$factura->time}}</td>
                        <td>{{$factura->estado->display_name}}</td>
                        <td>{{$factura->total}}</td>
                        <td>
                            <a href="{{ url('facturas/'.$factura->id )}}" class="btn btn-success"
                               title="Ver Factura"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--<div class="col-md-12" style="text-align: center">
                {{ $facturas->appends(Request::only(['numero']))->render() }}
            </div>--}}
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('js/moment-with-locales.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{url('js/factura.js')}}"></script>
@endsection