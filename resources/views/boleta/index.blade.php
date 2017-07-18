@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('css/s2-docs.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('styles')
    <style type="text/css" media="print">
        @media print {

            #sidebar-menu, #profile, #top-nav, #footer, #miga {
                display: none !important;
            }
            #titulo{
                width: 400px;
                float: left;
            }
            #logo_boleta{
                width: 225px;
                float: left;
                padding-top: 20px;
            }
            #all{
                font-size: 12px;
            }
            #panel{
                margin-top: -10px;

            }
            #general{
                width: 100%;
            }
            #resp{
                width: 100%;
                text-align: center;
                margin-left: 25px;
            }
            #sin_val{
                width: 50%;
            }
            #proto_panel{
                width: 100%;
            }
            #group_name{
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row" id="miga">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('facturas')}}">Facturas</a></li>
            <li><strong style="color: #0b97c4">Boleta ({{Auth::user()->sucursal->display_name}})</strong></li>
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
        <div class="x_panel" style="border-radius: 5px; border-style: solid; border-color: silver" id="panel">

            <div class="x_content" id="all">
                    @include('boleta.encabezado_boleta')
                    @include('boleta.info_general')
                {{--<div style="z-index: -100000; width: 500px; height: 500px; margin-top: -600px; margin-left: auto;margin-right: auto">--}}
                    {{--<img src="{{url('/storage/images/'. 'gota.png')}}" style="opacity: 0.10;z-index: -100000;">--}}
                {{--</div>--}}
                <?php
                $ind=0;
                $esp=0;
                $con_v=0;
                ?>
                @foreach($groupings as $group)

                    <div class="col-sm-12"
                         style="border-bottom: 2px solid;padding-top:8px;border-color: silver;margin-bottom: 0px" id="group_name">
                        <small><b>{{ $group->name }}</b></small>
                    </div>
                    <br/><br/>
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

                {{--Antibiotico--}}
                    {{--@include('boleta.antibioticos')--}}
                {{--Fin antibiotico--}}

                {{--Responsable--}}
                <br/><br/><br/><br/><br/><br/>
                <div class="col-md-12" style="margin-top: 20px" id="resp">
                    <div class="col-sm-3" style="text-align: center">
                        -------------------------------------------
                    </div>
                    <div class="col-md-6" style="text-align: center">
                       <h5>RESPONSABLE:</h5> <small><b>Lic. Yasmin Arevalo de Perez</b></small>
                    </div>
                    <div class="col-sm-3" style="text-align: center">
                        -------------------------------------------
                    </div>
                </div>
                {{--Fin Responsable--}}

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/select2/dist/js/select2.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('js/facturar.js')}}"></script>
@endsection