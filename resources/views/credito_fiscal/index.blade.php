@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Créditos Fiscales</li>
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
            <h3>Créditos Fiscales
                <a href="{{ route('credito_fiscal_customers') }}" title="Otorgar Cŕedito Fiscal" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-dollar fa-fw" aria-hidden="true"></i>Nuevo Crédito Fiscal
                    </div>
                </a>
            </h3>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">ID</th>
                        <th data-field="numero" data-sortable="true">Número</th>
                        <th data-field="cliente" data-sortable="true">Cliente</th>
                        <th data-field="facturador" data-sortable="true">Otorgado por</th>
                        <th data-field="estado" data-sortable="true">Estado</th>
                        <th data-field="monto" data-sortable="true">Monto (USD)</th>
                        <th data-field="actions" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($creditos_fiscales as $credito_fiscal)
                        <tr>
                            <td>{{$credito_fiscal->id}}</td>
                            <td>{{$credito_fiscal->numero}}</td>
                            <td>{{$credito_fiscal->facturas()->first()->cliente->razon_social}}</td>
                            <td>{{$credito_fiscal->user->getFullName()}}</td>
                            <td>@if($credito_fiscal->closed) Cerrado @else Abierto @endif</td>
                            <td>{{$credito_fiscal->total}}</td>
                            <td>
                                <a href="{{route('credito_fiscal_show',['id'=>$credito_fiscal->id])}}"
                                   class="btn btn-success"
                                   title="Ver Crédito Fiscal"><span class="fa fa-eye"></span></a>
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