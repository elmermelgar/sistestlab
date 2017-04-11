@extends('layouts.app')

@section('styles')
    <style>
        .profile_details{
            clear: inherit !important;
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Exámenes</li>
            <li>{{ $sucursal->display_name }}</li>
        </ol>
        <a href="{{ url('sucursales/view') }}" style="float: right; margin-top: -50px; margin-right: 20px; font-size: 9px" class="btn btn-dark"><i class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>
    </div>

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="x_panel2">

        <div class="x_title">
            <h3>Exámenes de {{ $sucursal->display_name }}
                <a href="{{ url('examenes/'.$sucursal->id.'/create') }}" title="Crear Nuevo Usuario" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Exámen
                    </div>
                </a>
            </h3>

            <div class="clearfix"></div>
        </div>


        <div class="x_content">
            <div class="row">
                @foreach($examnes as $examen)
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="{{ url('examenes/'.$sucursal->id.'/'.$examen->id )}}">
                        <div class="tile-stats" style="background: #FFFFFF">
                            <div class="icon"><i class="fa fa-newspaper-o"></i>
                            </div>
                            <div class="count">{{$examen->name}}</div>

                            <h3 style="font-size: 13px" class="list-inline count2"><b>{{ $examen->display_name }}</b></h3>
                            <p>{{ $examen->observation }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>



@endsection

@section('scripts')

@endsection