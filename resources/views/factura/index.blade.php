@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
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
            <h3 class="alignleft">Facturas</h3>
            <div class="alignright">
                <a href="{{ url('facturas/create') }}" title="Facturar" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-dollar fa-fw" aria-hidden="true"></i>Nueva Factura
                    </div>
                </a>
            </div>
            <div class="alignright">
                <div class="form-group pull-right top_search" style="margin-right: 5%">
                    <form class="form-group" action="{{ url('facturas') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="numero" placeholder="Buscar por número...">
                            <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">Buscar</button>
                    </span>
                        </div>
                    </form>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">ID</th>
                        <th data-field="name" data-sortable="true">Número</th>
                        <th data-field="cliente" data-sortable="true">Cliente</th>
                        <th data-field="facturador" data-sortable="true">Facturado por</th>
                        <th data-field="fecha" data-sortable="true">Fecha</th>
                        <th data-field="estado" data-sortable="true">Estado</th>
                        <th data-field="venta" data-sortable="true">Venta (USD)</th>
                        <th data-field="actions" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($facturas as $factura)
                        <tr>
                            <td>{{$factura->id}}</td>
                            <td>{{$factura->numero}}</td>
                            <td>{{$factura->cliente->razon_social}}</td>
                            <td>{{$factura->user->getFullName()}}</td>
                            <td>{{$factura->created_at}}</td>
                            <td>{{$factura->estado->display_name}}</td>
                            <td>{{$factura->total}}</td>
                            <td>
                                <a href="{{ url('facturas/'.$factura->id )}}" class="btn btn-success"
                                   title="Ver Factura"><span class="fa fa-eye"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                <div class="col-md-12" style="text-align: center">
                    {{ $facturas->appends(Request::only(['numero']))->render() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection