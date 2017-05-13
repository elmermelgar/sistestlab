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
            <h3>Facturas
                <a href="{{ url('facturar') }}" title="Facturar" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-dollar" aria-hidden="true"></i> Facturar
                    </div>
                </a>
            </h3>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table">
                <table class="table table-striped" id="datatable">
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">Id</th>
                        <th data-field="name" data-sortable="true">Número</th>
                        <th data-field="cliente" data-sortable="true">Cliente</th>
                        <th data-field="examenes" data-sortable="true">Examenes</th>
                        <th data-field="venta" data-sortable="true">Facturado por</th>
                        <th data-field="venta" data-sortable="true">Venta</th>
                        <th data-field="actions" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($facturas as $factura)
                        <tr>
                            <td>{{$factura->id}}</td>
                            <td>{{$factura->numero}}</td>
                            <td>{{$factura->cliente->razon_social}}</td>
                            <td>{{count($factura->examen_paciente)}}</td>
                            <td>{{$factura->user->getFullName()}}</td>
                            <td>{{$factura->total}}</td>
                            <td>
                                <a href="{{ url('facturas/'.$factura->id )}}"
                                   class="btn btn-success btn-sm" title="Ver Factura"><span
                                            class="fa fa-eye"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#datatable').dataTable();
        });
    </script>
@endsection