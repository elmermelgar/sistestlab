@extends('layouts.app')

@section('imports')
    <link href="{{url('css/bootstrap-table.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{route('credito_fiscal.index')}}">Créditos Fiscales</a></li>
            <li>@if($credito_fiscal) Modificar Crédito Fiscal @else Nuevo Crédito Fiscal @endif</li>
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
            <h3>@if($credito_fiscal) Modificar Crédito Fiscal @else Nuevo Crédito Fiscal @endif</h3>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <p><strong>Sucursal: </strong>{{$sucursal->display_name}}</p>
            <p><strong>Cliente: </strong>{{$cliente->razon_social}}</p>
            <p><strong>NIT Cliente: </strong>{{$cliente->nit}}</p>
            <p><strong>Entregado por: </strong>{{$user->name}}</p>
            <br>
            <p><strong>Facturas disponibles para crédito fiscal:</strong></p>
            <table id="facturas" data-classes="table table-hover table-no-bordered" data-icons-prefix="fa">
                <thead>
                <tr>
                    <th data-field="num" data-checkbox="true"></th>
                    <th data-field="id">ID</th>
                    <th data-field="fecha" data-sortable=true>Fecha</th>
                    <th data-field="estado">Estado</th>
                    <th data-field="facturador">Facturado por</th>
                    <th data-field="venta" data-sortable=true>Venta (USD)</th>
                    <th data-field="actions">Acciones</th>
                </tr>
                </thead>

                <tbody>
                @foreach($facturas as $factura)
                    <tr>
                        <td></td>
                        <td>{{ (int) $factura->id}}</td>
                        <td>{{$factura->created_at}}</td>
                        <td>{{$factura->estado->display_name}}</td>
                        <td>{{$factura->account->name()}}</td>
                        <td>{{$factura->total}}</td>
                        <td>
                            <a target="_blank" href="{{ url('facturas/'.$factura->id )}}" class="btn btn-success"
                               title="Ver Factura"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br><br>
            <form id="credito_fiscal_form" class="form form-inline" method="post"
                  action="{{route('credito_fiscal.store')}}">
                {{csrf_field()}}
                <div class="form-group hidden">
                    @if($credito_fiscal)
                        <input type="hidden" id="tax_credit_id" name="tax_credit_id" class="form-control" readonly
                               value="{{$credito_fiscal->id}}">
                    @endif
                    <input type="hidden" id="user_id" name="user_id" class="form-control" required readonly
                           value="{{$user->id}}">
                </div>
                <div class="form-group">
                    <label for="numero">Número de crédito fiscal:</label>
                    <input id="numero" name="numero" class="form-control" required maxlength="8"
                           value="{{$credito_fiscal? $credito_fiscal->numero:old('numero')}}">
                </div>
                <br><br><br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alignleft">
                            <a class="btn btn-default" href="{{URL::previous()}}">
                                <i class="fa fa-arrow-left fa-fw"></i>Regresar</a>
                        </div>
                        <div class="alignright">
                            <input type="submit" class="btn btn-primary" value="Continuar &#10140;">
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('js/bootstrap-table.min.js')}}"></script>
    <script src="{{url('js/creditofiscal.js')}}"></script>
    <script>
        @if($credito_fiscal)
        $(document).ready(function () {
            checkTaxCredits({{json_encode($credito_fiscal->facturas()->pluck('id')->all())}});
        });
        @endif
    </script>
@endsection