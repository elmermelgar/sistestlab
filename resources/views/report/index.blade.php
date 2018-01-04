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
                        <td>RPT_PRUEBAS</td>
                        <td>Pruebas facturadas</td>
                        <td>Lista de pruebas e ingresos por cliente o laboratorio de referencia en un rango de fechas.
                        </td>
                        <td><a href="{{route('report.pruebas')}}"><i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>RPT_REF_ESPECIFICA</td>
                        <td>Cantidad de prueba específica por laboratorio de referencia</td>
                        <td>Cantidad de prueba especifíca por laboratorio de referencia e ingreso en un rango de fechas.
                        </td>
                        <td><a href="{{route('report.ref_especifica')}}"><i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>RPT_SUC_ESPECIFICA</td>
                        <td>Cantidad de prueba específica por sucursal</td>
                        <td>Cantidad de prueba especifíca por sucursal e ingreso en un rango de fechas.</td>
                        <td><a href="{{route('report.suc_especifica')}}"><i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>RPT_REGISTRO</td>
                        <td>Registro de caja</td>
                        <td>Registro de caja por sucursal en un rango de fechas.</td>
                        <td><a href="{{route('report.registro')}}"><i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>RPT_REGISTRO_DETALLE</td>
                        <td>Detalle de registro de caja</td>
                        <td>Registro detallado de caja por sucursal en un rango de fechas.</td>
                        <td><a href="{{route('report.registro_detalle')}}">
                                <i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>RPT_LISTA_FACTURA</td>
                        <td>Lista de facturas</td>
                        <td>Lista de facturas por sucursal en un rango de fechas.</td>
                        <td><a href="{{route('report.lista_factura')}}">
                                <i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>RPT_LISTA_ANULADA</td>
                        <td>Lista de facturas anuladas</td>
                        <td>Lista de facturas anuladas por sucursal en un rango de fechas.</td>
                        <td><a href="{{route('report.lista_anulada')}}">
                                <i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>RPT_LISTA_NIVELES</td>
                        <td>Lista de facturas con descuentos o recargos</td>
                        <td>Lista de facturas con descuentos o recargos por sucursal en un rango de fechas.</td>
                        <td><a href="{{route('report.lista_niveles')}}">
                                <i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>RPT_LISTA_EXAMEN</td>
                        <td>Lista de exámenes</td>
                        <td>Lista de exámenes por sucursal.</td>
                        <td><a href="{{route('report.lista_examen')}}">
                                <i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>RPT_LISTA_ORIGEN</td>
                        <td>Lista de centros de origen</td>
                        <td>Lista de centros de origen por sucursal.</td>
                        <td><a href="{{route('report.lista_origen')}}">
                                <i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td>RPT_LISTA_PROVEEDOR</td>
                        <td>Lista de proveedores</td>
                        <td>Lista de proveedores.</td>
                        <td><a href="{{route('report.lista_proveedor')}}">
                                <i class="fa fa-arrow-circle-right fa-2x"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>13</td>
                        <td>RPT_EXISTENCIAS</td>
                        <td>Existencias en inventario</td>
                        <td>Existencias de recursos en inventario por sucursal.</td>
                        <td><a href="{{route('report.existencias')}}">
                                <i class="fa fa-arrow-circle-right fa-2x"></i></a>
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