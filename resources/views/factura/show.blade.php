@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('facturas')}}">Facturas</a></li>
            <li>{{$factura->id}}</li>
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
        <div class="col-sm-10">
            <div class="x_panel">

                <form class="form-horizontal">
                    <div class="x_content">
                        @include('factura.encabezado')
                        @include('factura.cliente')
                    </div>
                </form>

                <table class="table table-hover" id="factura">
                    <thead>
                    <tr>
                        <th data-sortable="true">Código</th>
                        <th data-sortable="true">Cantidad</th>
                        <th data-sortable="true">Descripción</th>
                        <th data-sortable="true">Precio unitario (USD)</th>
                        <th data-sortable="true">Venta gravada (USD)</th>
                    </tr>
                    </thead>

                    <tbody>
                    @php $total=0 @endphp
                    @foreach($profiles as $profile)
                        <tr>
                            @php
                                $subtotal=$profile->first()->price*$profile->count();
                                $total+=$subtotal;
                            @endphp
                            <td>{{$profile->first()->profile->name}}</td>
                            <td>{{$profile->count()}}</td>
                            <td>{{$profile->first()->profile->display_name}}</td>
                            <td>{{$profile->first()->price}}</td>
                            <td>{{number_format($subtotal,2)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-sm-12">
                    <div class="alignright"><h4>TOTAL USD: {{number_format($total,2)}} </h4></div>
                </div>
                <br><br>
                <div class="col-sm-12">
                    @if($factura->estado->name==\App\Factura::BORRADOR)
                        <div class="alignleft">
                            <a class="btn btn-info btn-lg" href="{{route('factura_edit', ['id' => $factura->id])}}">
                                <i class="fa fa-edit"></i> Modificar</a>
                            <a class="btn btn-danger btn-lg"
                               onclick="Anular({{$factura->id}})">
                                <i class="fa fa-times"></i> Anular</a>
                        </div>
                        <div class="alignright">
                            <a class="btn btn-primary btn-lg" data-toggle="modal"
                               data-target="#modal_facturar"><i class="fa fa-clipboard"></i> FACTURAR
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    @if($factura->estado->name==\App\Factura::ABIERTA||$factura->estado->name==\App\Factura::CERRADA)
        <div class="row">
            <div class="col-sm-10">
                <div class="x_panel">
                    <div class="x_title">
                        <h4>Pagos</h4>
                    </div>
                    <div class="x_content">

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Monto (USD)</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($factura->payments as $payment)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$payment->amount}}</td>
                                    <td>@if($payment->Type==\App\Transaction::CASH)Efectivo
                                        @else Débito
                                        @endif
                                    </td>
                                    <td>{{$payment->transaction->date.' '.$payment->transaction->time}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Sin pagos!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="col-sm-12">
                            <div class="alignright"><h4>SUMA USD: {{$suma}} </h4></div>
                        </div>
                        <div class="col-sm-12">
                            <div class="alignright"><h4>DEUDA USD: {{number_format($total-$suma,2)}} </h4></div>
                        </div>
                        @if($factura->estado->name==\App\Factura::ABIERTA)
                            <a class="alignright btn btn-primary" data-toggle="modal"
                               data-target="#modal_pago"><i class="fa fa-dollar fa-fw"></i>Registrar pago</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($factura->estado->name==\App\Factura::BORRADOR||$factura->estado->name==\App\Factura::ABIERTA)
        @include('factura.modal_facturar')
        @include('factura.modal_pago')
    @endif
    @if($factura->estado->name==\App\Factura::BORRADOR)
        @include('factura.modal_anular')
    @endif

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    @if($factura->estado->name==\App\Factura::BORRADOR||$factura->estado->name==\App\Factura::ABIERTA)
        <script src="{{url('js/facturar.js')}}"></script>
    @endif
@endsection