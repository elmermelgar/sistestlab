@extends('layouts.app')

@section('styles')
    <style>
        .profile_details {
            clear: inherit !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Perfiles</li>
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

    <div class="x_panel">

        <div class="x_title">
            <h3>Perfiles de exámenes

                <a href="{{ url('perfiles/create') }}" title="Crear Nuevo Perfil"
                   style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> Nuevo Perfil
                    </div>
                </a>
                <div class="col-md-3 col-sm-4 col-xs-12 form-group pull-right top_search" style="margin-right: 5%">
                    <form class="form-group" action="{{ url('perfiles') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="display_name" placeholder="Buscar perfil...">
                            <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">Buscar</button>
                    </span>
                        </div>
                    </form>
                </div>
            </h3>


            <div class="clearfix"></div>
        </div>


        <div>
            <div class="row">
                @foreach($perfiles as $perfil)
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 " style="height: 200px">
                        <a href="{{ url('perfiles/'.$perfil->id )}}">
                            <div class="tile-stats" style="background: #FFFFFF;">
                                <div class="icon"><i class="fa fa-newspaper-o"></i>
                                </div>
                                <div class="count">{{$perfil->name}}</div>

                                <h3 style="font-size: 13px" class="list-inline count2">
                                    <b>{{ $perfil->display_name }}</b></h3>
                                <div style="overflow-y: hidden; height: 85px"><p>{{ $perfil->description }}</p></div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-12" style="text-align: center">
            {{ $perfiles->appends(Request::only(['display_name']))->render() }}
        </div>
    </div>


@endsection

@section('scripts')

@endsection