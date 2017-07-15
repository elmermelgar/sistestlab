@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('facturas')}}">Facturas</a></li>
            <li><strong style="color: #0b97c4">Nueva Factura ({{Auth::user()->sucursal->display_name}})</strong></li>
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

    <div class="col-sm-10">
        <div class="x_panel">

            <div class="x_content">

                <form id="form" class="form-horizontal" method="post" action="{{url('/facturas/store')}}">
                    {{csrf_field()}}
                    @include('factura.encabezado')
                    @include('factura.cliente')

                    <div class="row">
                        <table id="factura" class="table table-hover">
                            <thead>
                            <tr>
                                <th data-field="id" data-sortable="false">#</th>
                                <th data-field="examen" data-sortable="true">Examen(es)&emsp;</th>
                                <th data-field="paciente" data-sortable="true">Paciente&emsp;&emsp;</th>
                                <th data-field="surname" data-sortable="true">Precio (USD)</th>
                                <th data-field="actions" data-sortable="false">Acciones</th>
                            </tr>
                            </thead>
                            <tbody id="factura_body">
                            @foreach($perfiles as $perfil)
                                <tr>
                                    <td></td>
                                    <td>
                                        {{$perfil->profile->name.' '.$perfil->profile->display_name}}
                                        <div class="form-group hidden">
                                            <input type="hidden" name="invoice_profile_id[]" required
                                                   value="{{$perfil->id}}">
                                            <input type="hidden" name='profile_id[]'>
                                            <input type="hidden" name='numero_boleta[]'>
                                            <input type="hidden" name='paciente_nombre[]'>
                                            <input type="hidden" name='paciente_edad[]'>
                                            <input type="hidden" name='paciente_genero[]'>
                                        </div>
                                    </td>
                                    <td>
                                        {{$perfil->examen_paciente->first()->paciente_nombre}}
                                        {{$perfil->examen_paciente->first()->paciente_edad}}
                                        {{$perfil->examen_paciente->first()->paciente_genero}}
                                        Boleta: {{$perfil->examen_paciente->first()->numero_boleta}}
                                    </td>
                                    <td>{{$perfil->price}}</td>
                                    <td>
                                        <div class='btn btn-danger delete'><i class='fa fa-times'></i></div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                    </div>

                    <div class="alignleft">
                        <a class="btn btn-default btn-lg" href="{{URL::previous()}}">Cancelar</a>
                    </div>
                    <div class="form-group alignright">
                        <div class="btn btn-success btn-lg" data-toggle="modal"
                             data-target="#modal_profile"><i class="fa fa-plus fa-fw"></i>Agregar exámen o perfil
                        </div>
                        <input id="submit" type="submit" class="btn btn-primary btn-lg" value="Continuar">
                    </div>

                </form>
                <br>

            </div>
        </div>
    </div>


    <!-- Examen Modal -->
    @if($centro_origen)
        @include('factura.modal_perfil_origen')
    @else
        @include('factura.modal_perfil_cliente')
    @endif
@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/select2/dist/js/select2.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('js/facturaedit.js')}}"></script>
@endsection