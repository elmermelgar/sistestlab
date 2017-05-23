@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('css/s2-docs.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Facturar</li>
        </ol>
    </div>
    @include('noscript')
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
            <h3>Facturar</h3>
        </div>
    </div>

    <div class="x_panel">

        <div class="x_content">

            <form id="form" class="form-horizontal" method="post" action="{{url('facturas/store')}}">
                {{csrf_field()}}
                @include('factura.encabezado')
                @include('factura.cliente')

                <br><br>
                <div class="row">
                    <table id="factura" class="table table-hover">
                        <thead>
                        <tr>
                            <th data-field="id" data-sortable="false">#</th>
                            <th data-field="examen" data-sortable="true">Exámen</th>
                            <th data-field="paciente" data-sortable="true">Paciente</th>
                            <th data-field="surname" data-sortable="true">Precio unitario (USD)</th>
                            <th data-field="actions" data-sortable="false">Acciones</th>
                        </tr>
                        </thead>
                        <tbody id="factura_body">

                        </tbody>
                    </table>

                </div>

                <div class="form-group alignright">
                    <div class="btn btn-success btn-lg " data-toggle="modal"
                         data-target="#modal_examen"><i class="fa fa-plus fa-fw"></i>Agregar exámen
                    </div>
                    <input id="submit" type="submit" class="btn btn-primary btn-lg" value="Continuar">
                </div>

            </form>
            <br>

        </div>
    </div>


    <!-- Examen Modal -->
    @if(isset($centro_origen))
        @include('factura.modal_centro_origen')
    @else
        @include('factura.modal_cliente')
    @endif
@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/select2/dist/js/select2.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('js/facturar.js')}}"></script>
@endsection