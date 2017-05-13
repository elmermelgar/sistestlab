@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('css/s2-docs.css')}}" rel="stylesheet" type="text/css"/>
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

    <div class="page-title">
        <div class="title_left">
            <h3>Factura {{$factura->id}}</h3>
        </div>
    </div>

    <div class="x_panel">

        <form class="form-horizontal">
            <div class="x_content">
                @include('factura.encabezado')
                @include('factura.cliente')
            </div>
        </form>

        <br><br>
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
            @foreach($examenes as $examen)
                <tr>
                    @php
                        $subtotal=$examen->first()->exam->precio*$examen->count();
                        $total+=$subtotal;
                    @endphp
                    <td>{{$examen->first()->exam_id}}</td>
                    <td>{{$examen->count()}}</td>
                    <td>{{$examen->first()->exam->display_name}}</td>
                    <td>{{$examen->first()->exam->precio}}</td>
                    <td>{{$subtotal}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="col-sm-12">
            <div class="alignright"><h4>TOTAL USD: $ {{$total}} </h4></div>
        </div>
        <br><br>
        <div class="col-sm-12">
            <div class="alignright">
                <div class="btn btn-primary btn-lg" data-toggle="modal"
                     data-target="#modal_facturar"><i class="fa fa-clipboard"></i> FACTURAR
                </div>
            </div>
        </div>
    </div>

    @include('factura.modal_facturar')

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#factura').dataTable({
                "paging": false,
                "language": {
                    "search": "Buscar:",
                    "info": "Mostrando _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 de 0 entradas",
                    "zeroRecords": "Sin registros"
                }
            });


            function suma() {
                var total=parseFloat($('#total').val());
                var efectivo=parseFloat($('#efectivo').val());
                var debito=parseFloat($('#debito').val());
                var deuda=parseFloat($('#deuda').val());
                var suma=(efectivo+debito+deuda).toFixed(2);
                $('#suma').val(suma);
                if(suma!=total){
                    $('#suma').css('color','red');
                    $('#facturar').attr('disabled', 'disabled');
                }
                else{
                    $('#suma').css('color','green');
                    $('#facturar').removeAttr('disabled');
                }
            }

            $('#efectivo').bind('input', function () {
                suma();
            });
            $('#debito').bind('input', function () {
                suma()
            });
            $('#deuda').bind('input', function () {
                suma()
            });

        });
    </script>
@endsection