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
            <h3 class="alignleft">Créditos Fiscales</h3>
            <div class="alignright">
                <a href="{{ route('credito_fiscal.customers') }}" title="Otorgar Cŕedito Fiscal" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-dollar fa-fw" aria-hidden="true"></i>Nuevo Crédito Fiscal
                    </div>
                </a>
            </div>
            <div class="alignright">
                <div class="form-group pull-right top_search" style="margin-right: 5%">
                    <form class="form-group" action="{{ route('credito_fiscal.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="numero"
                                   placeholder="Buscar por número...">
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
                                <a href="{{route('credito_fiscal.show',['id'=>$credito_fiscal->id])}}"
                                   class="btn btn-success"
                                   title="Ver Crédito Fiscal"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-12" style="text-align: center">
                    {{ $creditos_fiscales->appends(Request::only(['numero']))->render() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection