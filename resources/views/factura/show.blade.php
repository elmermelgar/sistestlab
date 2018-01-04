@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('css/bootstrap-slider.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            @if(isset($credito_fiscal))
                <li><a href="{{route('credito_fiscal.index')}}">Créditos Fiscales</a></li>
            @else
                <li><a href="{{url('facturas')}}">Facturas</a></li>
            @endif
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

                <table class="table table-hover table-condensed" id="factura">
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
                                $price=$profile->first()->price*(1+$factura->nivel);
                                $subtotal=$price*$profile->count();
                                $total+=$subtotal;
                            @endphp
                            <td>{{$profile->first()->profile->name}}</td>
                            <td>{{$profile->count()}}</td>
                            <td>{{$profile->first()->profile->display_name}}</td>
                            <td>{{number_format($price,2)}}</td>
                            <td>{{number_format($subtotal,2)}}</td>
                        </tr>
                    @endforeach
                    @php $total=round($total+0.004, 2)@endphp
                    </tbody>
                </table>
                <div class="col-sm-12">
                    <div class="alignright"><h4>TOTAL USD: {{number_format($total,2)?:$factura->total}} </h4></div>
                </div>
                <br><br>
                <div class="col-sm-12">
                    {{--cuando la factura sea un borrador, que pueda modificar, anular o facturar--}}
                    @if($factura->estado->name==\App\Factura::BORRADOR)
                        <div class="alignleft">
                            <a class="btn btn-info btn-lg" href="{{route('factura.edit', ['id' => $factura->id])}}">
                                <i class="fa fa-edit fa-fw"></i>Modificar</a>
                            <a class="btn btn-danger btn-lg" onclick="Anular({{$factura->id}})">
                                <i class="fa fa-times fa-fw"></i>Anular</a>
                            {{--si tiene permiso, que pueda aplicar un descuento o un recargo--}}
                            @permission('admin_niveles')
                            <a class="btn btn-default btn-lg" data-toggle="modal" data-target="#modal_nivel">
                                <i class="fa fa-percent fa-fw"></i>
                                @if($factura->nivel==0)Aplicar nivel @else Modificar nivel @endif</a>
                            @endpermission
                        </div>
                        <div class="alignright">
                            <a class="btn btn-primary btn-lg" data-toggle="modal"
                               data-target="#modal_facturar"><i class="fa fa-clipboard"></i> FACTURAR
                            </a>
                        </div>

                        {{--cuando sea un crédito fiscal y esté no esté cerrado, que se pueda modificar o cerrar.
                         Los créditos fiscales, aunque se tratan como si fuesen una factura normal, no manejan los
                         mismos estados, por lo que se revisan de la forma: $factura->closed --}}
                    @elseif(isset($credito_fiscal)&&!$factura->closed)
                        <div class="alignleft">
                            <a class="btn btn-info btn-lg"
                               href="{{route('credito_fiscal.edit', ['id' => $factura->id])}}">
                                <i class="fa fa-edit fa-fw"></i>Modificar</a>
                        </div>
                        <div class="alignright">
                            <form class="form" method="post" action="{{route('credito_fiscal.close')}}">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <input type="hidden" name="tax_credit_id" value="{{$factura->id}}">
                                    <input type="submit" value="&#10004; TERMINAR" class="btn btn-primary btn-lg">
                                </div>
                            </form>
                        </div>
                    @elseif(!$factura->credito_fiscal&&$factura->estado->name!=\App\Factura::ANULADA)
                        <div class="alignright">
                            <a class="btn btn-default btn-lg" data-toggle="modal"
                               data-target="#modal_numero"><i class="fa fa-hashtag"></i> Cambiar número
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{--cuando la factura esté abierta o cerrada y además no sea un crédito fiscal, que muestre los pagos--}}
    @if(($factura->estado->name==\App\Factura::ABIERTA||$factura->estado->name==\App\Factura::CERRADA)
    &&!isset($credito_fiscal))
        <div class="row">
            <div class="col-sm-10">
                <div class="x_panel">
                    <div class="x_title">
                        <h4>Pagos</h4>
                    </div>
                    <div class="x_content">

                        <table class="table table-hover table-condensed">
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
                                    <td>@if($payment->type==\App\Transaction::CASH)Efectivo
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
                        {{--cuando la factura esté abierta, que pueda realizar pagos--}}
                        @if($factura->estado->name==\App\Factura::ABIERTA)
                            <a class="alignright btn btn-primary" data-toggle="modal"
                               data-target="#modal_pago"><i class="fa fa-dollar fa-fw"></i>Registrar pago</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!isset($credito_fiscal))
        {{--cuando la factura esté abierta y no sea un crédito fiscal, que pueda realizar pagos--}}
        @if($factura->estado->name==\App\Factura::ABIERTA)
            @include('factura.modal_pago')
        @endif
        {{--cuando la factura sea un borrador y no sea un crédito fiscal, que pueda facturar o anular--}}
        @if($factura->estado->name==\App\Factura::BORRADOR)
            @include('factura.modal_facturar')
            @include('factura.modal_anular')
            {{--si tiene permiso, que pueda aplicar un descuento o un recargo--}}
            @permission('admin_niveles')
            @include('factura.modal_nivel')
            @endpermission

        @elseif($factura->estado->name!=\App\Factura::ANULADA)
            @include('factura.modal_numero')
        @endif

    @endif

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('js/bootstrap-slider.min.js')}}"></script>
    {{--cuando la factura sea un borrador o esté abierta y además no sea un crédito fiscal, que cargue el script que
    calcula la suma de los montos de pagos y la deuda--}}
    @if(($factura->estado->name!=\App\Factura::ANULADA)&&!isset($credito_fiscal))
        <script src="{{url('js/facturar.js')}}"></script>
    @endif
@endsection