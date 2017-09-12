@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><strong style="color: #0b97c4">Boletas Pendientes</strong></li>

            {{--<li>{{$detail? $detail->name_detail:'Nuevo'}}</li>--}}
        </ol>
        {{--<a href="{{ url('examenes/'.$examen->id) }}"--}}
           {{--style="float: right; margin-top: -50px; margin-right: 20px; font-size: 9px" class="btn btn-dark"><i--}}
                    {{--class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>--}}
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


            <h3>Examenes Pendientes: </h3>
            {{--<h2>Null</h2>--}}

            <a href="{{ url('/results/invoice/all')}}" style="float: right; margin-top: -35px" class="btn btn-sm bg-green">
                [<i class="fa fa-print" aria-hidden="true"></i>] Boletas Listas
            </a>

            <div class="clearfix"></div>
        </div>
        {{--<div class="x_content">--}}
            {{--<div class="col-md-2"></div>--}}
            {{--<div class="col-md-8">--}}
                {{--<table class="table table-striped">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<th>#</th>--}}
                        {{--<th>Valor</th>--}}
                        {{--<th>Unidades</th>--}}
                        {{--<th>Sexo</th>--}}
                        {{--<th>Edad Menor</th>--}}
                        {{--<th>Edad Mayor</th>--}}
                        {{--<th>*</th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--@foreach($references as $reference)--}}
                        {{--<tr>--}}
                            {{--<th scope="row">1</th>--}}
                            {{--<td>{{ $reference->value }}</td>--}}
                            {{--<td>{{ $reference->unidades }}</td>--}}
                            {{--<td>{{ $reference->gender  }}</td>--}}
                            {{--<td>{{ $reference->edad_menor }}</td>--}}
                            {{--<td>{{ $reference->edad_mayor }}</td>--}}
                            {{--<td>--}}
                                {{--<a href="{{url('examenes/'.$examen->id.'/'.$detail->id.'/delete_reference/'.$reference->id)}}"--}}
                                   {{--class="btn btn-sm btn-danger">--}}
                                    {{--<i class="fa fa-trash" aria-hidden="true"></i>--}}
                                {{--</a>--}}
                            {{--</td>--}}

                        {{--</tr>--}}
                    {{--@endforeach--}}

                {{--</table>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="x_content">

            <p>Aqui se mustran los examenes que aun no se les llenan resultados y los denegados para ser editados</p>
            <!-- start project list -->
            <table class="table table-striped projects " id="datatable">
                <thead>
                <tr>
                    <th style="width: 20%">Examen</th>
                    <th>Fecha de Ingreso</th>
                    <th>Pertenece</th>
                    <th>Hora</th>
                    <th>Boleta</th>
                    {{--<th>Progreso de Laboratorio</th>--}}
                    <th>Estado</th>
                    <th style="width: 20%">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @if($examenes)
                @foreach($examenes as $examen)
                    @if($examen->invoices->factura->sucursal_id == Auth::user()->sucursal_id)
                        {{--@if($examen->estado_id == null or $examen->estado->name == 'denegado')--}}
                        <tr>
                            <td>
                                {{ $examen->exam->name}} - <a>{{ $examen->exam->display_name}}</a>
                            </td>
                            <td>
                                Cliente:<small>{{ $examen->invoices->factura->cliente->name}}</small>
                                <br/>
                                Paciente:<small>{{ $examen->paciente_nombre}}</small>
                            </td>
                            <td>
                                {{ date_format($examen->created_at, 'd/m/Y')  }}
                            </td>
                            <td>
                                {{ date_format($examen->created_at, 'g:m:s a')  }}
                            </td>
                            <td>{{ $examen->numero_boleta }}</td>
                            {{--<td class="project_progress">--}}
                            {{--<div class="progress progress_sm">--}}
                            {{--<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="57" aria-valuenow="55" style="width: 57%;"></div>--}}
                            {{--</div>--}}
                            {{--<small>57% Complete</small>--}}
                            {{--</td>--}}
                            <td>

                                    @if($examen->estado->name == 'facturado')
                                        Sin resultados
                                    @elseif($examen->estado->name == 'denegado' )
                                        <button type="button" class="btn  btn-xs"
                                                style="background: #cc0000; color: #FFFFFF">
                                            Denegado
                                        </button>
                                    @elseif($examen->estado->name == 'proceso' )
                                        <button type="button" class="btn  btn-xs"
                                                style="background: #eb9316; color: #FFFFFF">
                                            En Proceso
                                        </button>
                                    @else
                                        <button type="button" class="btn  btn-xs"
                                                style="background: #00A000; color: #FFFFFF">
                                            Validado
                                        </button>
                                    @endif

                            </td>
                            <td>
                                @if($examen->estado->name == 'facturado')
                                    <a href="{{url('results/'.$examen->exam->id.'/'.$examen->id.'/complete')}}"
                                       class="btn btn-primary bg-purple"><i class="fa fa-pencil-square"></i> Llenar
                                        resultados</a>
                                @elseif($examen->estado->name == 'denegado' )
                                    <a href="{{url('results/'.$examen->exam->id.'/'.$examen->id.'/complete')}}"
                                       class="btn btn-primary bg-orange"><i class="fa fa-pencil-square"></i> Corregir
                                        resultados</a>
                                    {{--<a href="#" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>--}}
                                    {{--<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>--}}
                                @endif
                            </td>
                        </tr>
                        {{--@endif--}}
                    @endif
                @endforeach
                @endif
                </tbody>
            </table>
            <!-- end project list -->

        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection
@section('script-codigo')
    <script>
        $(document).ready(function () {
            $('#datatable').dataTable();
        });
    </script>
@endsection