@extends('layouts.app')

@section('imports')
    <link href="{{url('css/s2-docs.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('css/imprimir_boleta.css')}}" rel="stylesheet" type="text/css" media="print"/>
@endsection

@section('content')
    <div class="row" id="miga">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/results/invoice/process')}}">Boletas en Proceso</a></li>
            <li><strong style="color: #0b97c4">Boleta N°{{ $examen_paciente->numero_boleta }} ({{Auth::user()->sucursal->display_name}})</strong></li>
        </ol>
        <a href="{{ url('/results/invoice/process') }}" style="float: right; margin-top: -50px; margin-right: 20px; font-size: 9px"
           class="btn btn-dark"><i class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>
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

    <div class="col-sm-10" id="panel_comp">
        <div class="x_panel" style="border-radius: 5px; border-style: solid; border-color: silver" id="panel">

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
                    ?>
                    <div class="col-md-12"
                         style="border-bottom: 2px solid;padding-top:8px;border-color: silver;margin-bottom: 5px" id="group_name">
                        <small><b>{{ $group->name }}</b></small>
                    </div>

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
                            {{--Grupos sin valores de referencia--}}
                            @include('boleta.sin_valores_referencia')
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
                    <br/>
                @endforeach
                @if(count($registro_antibioticos)>0)
                {{--Antibiotico--}}
                    @include('boleta.antibioticos')
                {{--Fin antibiotico--}}
                @endif
                {{--Responsable--}}
                {{--<br/><br/><br/><br/><br/><br/>--}}
                @if($examen_paciente->profesional)
                    <div class="col-md-12" style="margin-top: 10px" id="resp">
                        <div class="col-sm-3" style="text-align: center">
                            -------------------------------------------
                        </div>
                        <div class="col-md-6" style="text-align: center">
                            <h5>RESPONSABLE:</h5>
                            <small>
                                <b>Lic. {{ $examen_paciente->profesional->name }} {{ $examen_paciente->profesional->surname }}</b>
                            </small>
                        </div>
                        <div class="col-sm-3" style="text-align: center">
                            -------------------------------------------
                        </div>
                    </div>
                @endif
                {{--Fin Responsable--}}

            </div>
        </div>
    </div>
    <div class="col-sm-2" id="botones">
        @if($examen_paciente->estado->name=='validado')
            <a href="javascript:window.print(); void 0;" class="btn bg-green" style="width: 100%"><i
                        class="fa fa-print"></i> Imprimir Boleta</a>
            <br/>
        @endif
        <b>Area: </b>{{ $examen_paciente->exam->exam_category->name }}
            @if($examen_paciente->exam->exam_category->name=='(B)Bacteriología')
        <a href="#" class="btn bg-orange" data-toggle="modal"
           data-target=".bs-example-modal-sm" style="width: 100%"> Agregar Antibióticos</a>
        @endif

        @php $rol=DB::table('roles')->where([
                                            ['name', '=', 'profesional'],])->first();
                $rol_user=DB::table('role_user')->where([
                                                 ['user_id', '=', Auth::User()->id],
                                                 ['role_id', '=', $rol->id],])->first();
        @endphp
        @if($rol_user)
            @if($examen_paciente->estado->name!='validado')
                    <a href="#" class="btn bg-red" data-toggle="modal"
                       data-target=".denegar" style="width: 100%"> Denegar</a>

                <button type="submit" onclick="aprobar({{ $examen_paciente->id }})" class="btn bg-purple"
                        style="width: 100%"> Aprobar
                </button>
            @endif
        @endif

    </div>
    {{--Modal de Antibioticos--}}
    @include('boleta.antibioticos_modal')
    {{--Fin Modal de Antibioticos--}}
    {{--Modal de Denegar Boleta--}}
    @include('boleta.denegar_modal')
    {{--Fin Modal de Denegar Boleta--}}
@endsection
@section('script-codigo')
    <script>
        $('#flash-overlay-modal').modal();
        function aprobar(id) {
            (new PNotify({
                title: 'Esta a punto de Aprobar una boleta que contiene resultados',
                text: 'Esta seguro(a) que no tiene ningún error?',
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                confirm: {
                    confirm: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                }
            })).get().on('pnotify.confirm', function() {
                location.href = '/results/'+id+'/storeaprobar';
            }).on('pnotify.cancel', function() {
            });
        }
    </script>

    @endsection