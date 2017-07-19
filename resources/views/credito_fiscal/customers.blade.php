@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{route('credito_fiscal_index')}}">Créditos Fiscales</a></li>
            <li>Clientes</li>
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
            <h3>Clientes con créditos fiscal disponibles</h3>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <p>A continuación se muestran los clientes que poseen una o más facturas marcadas como crédito fiscal.</p>
            <div class="table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">ID Cliente</th>
                        <th data-field="nit" data-sortable="true">NIT</th>
                        <th data-field="cliente" data-sortable="true">Cliente</th>
                        <th data-field="facturas" data-sortable="true">Cantidad de facturas</th>
                        <th data-field="monto" data-sortable="true">Monto (USD)</th>
                        <th data-field="actions" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td>{{$cliente->id}}</td>
                            <td>{{$cliente->nit}}</td>
                            <td>{{$cliente->razon_social}}</td>
                            <td>{{$cliente->cantidad_facturas}}</td>
                            <td>{{$cliente->total}}</td>
                            <td>
                                <a href="{{ route('credito_fiscal_create',['cliente_id'=>$cliente->id] )}}"
                                   title="Otorgar Crédito Fiscal"><span class="fa fa-arrow-right fa-2x"></span></a>
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
@endsection