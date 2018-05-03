@extends('layouts.app88')
@section('imports')
    <style>
        #table_result tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
@endsection
@section('content')

    <div class="col-sm-10" id="panel_comp">
        <div class="x_panel" style="border-radius: 5px; border-color: silver" id="panel">

            <div class="x_content" id="all">
                @include('boleta.encabezado_boleta')
                @include('boleta.info_general')
                {{--<div style="z-index: -100000; width: 500px; height: 500px; margin-top: -600px; margin-left: auto;margin-right: auto">--}}
                {{--<img src="{{url('/storage/images/'. 'gota.png')}}" style="opacity: 0.10;z-index: -100000;">--}}
                {{--</div>--}}

                @foreach($groupings as $group)
                    <?php
                    $ind=0;
                    $esp=0;
                    $con_v=0;
                    $sin_v=0;
                    ?>
                    {{--<div class="col-md-12"--}}
                         {{--style="border-bottom: 2px solid;padding-top:4px;border-color: silver;margin-bottom: 5px" id="group_name">--}}
                        {{--<small><b>{{ $group->name }}</b></small>--}}
                    {{--</div>--}}

                    {{--<br/><br/>--}}
                    @foreach($details as $detail)
                        @if($detail->grouping_id == $group->id)
                            @if($detail->referenceType->name == 'default')
                                @php
                                    $con_v=$con_v+1;
                                @endphp
                                {{--GRUPOS con valores de referencia--}}
                                @include('boleta.con_valores_referencia')
                                {{--Fin grupo con valores de referencia--}}
                            @endif
                            @if($detail->referenceType->name == 'ninguno')
                            {{--Grupos sin valores de referencia--}}
                                @php
                                    $sin_v=$sin_v+1;
                                @endphp
                            @include('boleta.sin_valores_referencia')
                            @endif
                            {{--Fin grupo sin valores de referencia--}}
                            @if($detail->referenceType->name == 'protozoarios')
                                @php
                                    $ind=$ind+1;
                                @endphp
                                {{--Grupos Protozoarios--}}
                                @include('boleta.protozoarios')
                                {{--Fin grupo protozoarios--}}

                            @endif
                            @if($detail->referenceType->name == 'espermograma')
                                @php
                                    $esp=$esp+1;
                                @endphp
                                {{--Grupo Espermograma--}}
                                @include('boleta.espermograma')
                                {{--Fin grupo spermograma--}}
                            @endif
                        @endif
                    @endforeach
                    {{--<br/>--}}
                @endforeach
                @if(count($registro_antibioticos)>0)
                    {{--Antibiotico--}}
                    @include('boleta.antibioticos')
                    {{--Fin antibiotico--}}
                @endif
                {{--Responsable--}}
                {{--<br/><br/><br/><br/><br/><br/>--}}
                {{--@if($examen_paciente->profesional)--}}
                    {{--<div class="col-md-12" style="margin-top: 10px" id="resp">--}}
                        {{--<div class="col-sm-3" style="text-align: center">--}}
                            {{-----------------------------------------------}}
                        {{--</div>--}}
                        {{--<div class="col-md-6" style="text-align: center">--}}
                            {{--<h5>RESPONSABLE:</h5>--}}
                            {{--<small>--}}
                                {{--<b>Lic. {{ $examen_paciente->profesional->name() }}</b>--}}
                            {{--</small>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-3" style="text-align: center">--}}
                            {{-----------------------------------------------}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endif--}}
                {{--Fin Responsable--}}
                <div class="col-md-12" style="margin-top: 40px; margin-bottom: 1px; z-index: auto; display: block" id="resp">
                    <div class="col-sm-3" style="text-align: center; font-size: 12px">
                        <b>Nota: (<b style="color: #cc0000">*</b>) Implica valor fuera del rango de referencia.</b>
                    </div>
                    <br/>
                    <div class="col-sm-3" style="text-align: center; font-size: 14px">
                        TestLab &reg;
                    </div>
                    <div class="col-md-6" style="text-align: center; font-size: 10px">
                        Mas que una <b>PRUEBA</b>, una vida.<br/><br/>
                        <small>
                            <b>SERVICIO DE ANÁLISIS Y ESTUDIO DE DIAGNÓSTICO</b>
                        </small>
                        <br/>
                        {{ Auth::user()->account->sucursal->direccion }}
                        <br/>
                        Tel: {{ Auth::user()->account->sucursal->telefono }} / Email: info@testlab.com.sv / <a href="#">wwww.facebook.com/laboratorioclinicotestlab/</a>
                    </div>

                </div>

            </div>
        </div>
    </div>


@endsection