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

    <div class="x_panel2">

        <div class="x_title">
            <h3>Exámenes de la Sucuarsal:
                <a href="{{ url('examenes/create') }}" title="Crear Nuevo Usuario" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Exámen
                    </div>
                </a>
            </h3>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="row">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-newspaper-o"></i>
                        </div>
                        <div class="count">M(12)</div>

                        <h3 style="font-size: 13px">TRANSAMINASA GLUTAMINICA</h3>
                        <p>Lorem ipsum psdea itgum rixt.</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-newspaper-o"></i>
                        </div>
                        <div class="count">M(12)</div>

                        <h3 style="font-size: 13px">TRANSAMINASA GLUTAMINICA</h3>
                        <p>Lorem ipsum psdea itgum rixt.Lorem ipsum psdea itgum rixt Lorem ipsum psdea itgum rixt</p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="#">
                        <div class="tile-stats" style="background: #FFFFFF">
                            <div class="icon"><i class="fa fa-newspaper-o"></i>
                            </div>
                            <div class="count">M(12)</div>

                            <h3 style="font-size: 13px" class="list-inline count2"><b>TRANSAMINASA GLUTAMINICA CON
                                    OBJETIVO DE PROBAR EL DESBORDAMIENTO</b></h3>
                            <p>Lorem ipsum psdea itgum rixt. Lorem ipsum psdea itgum rixt Lorem ipsum psdea itgum
                                rixt</p>
                        </div>
                    </a>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-newspaper-o"></i>
                        </div>
                        <div class="count">M(12)</div>

                        <h3 style="font-size: 13px">TRANSAMINASA GLUTAMINICA</h3>
                        <p>Lorem ipsum psdea itgum rixt.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')

@endsection