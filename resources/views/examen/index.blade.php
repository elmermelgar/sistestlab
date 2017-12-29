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
            <li>Exámenes</li>
        </ol>
        <a href="{{ url('examenes') }}" style="float: right; margin-top: -50px; margin-right: 20px; font-size: 9px"
           class="btn btn-dark"><i class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>
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
            <h3>Exámenes

                <a href="{{ url('examenes/create') }}" title="Crear Nuevo Examen" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-user-plus"></i> Nuevo Exámen
                    </div>
                </a>
                <div class="col-md-6  form-group pull-right top_search" style="margin-right: 12%; text-align: center">
                    <form class="form-group" action="{{ url('examenes') }}" method="GET">
                        <div class="input-group  col-md-6 " style="float: left">
                            <select class="form-control" name="category" style="border-radius: 25px 0px 0px 25px;">
                                <option value="0">Seleccione una categoría...</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group col-md-6" style="float: right;">
                            <input class="form-control" style="border-radius: 0px 0px 0px 0px;" name="display_name" placeholder="Buscar examen...">

                            <span class="input-group-btn">

                      <button class="btn btn-default" style="background: #1ABB9C; color: #FFFFFF">Buscar</button>
                    </span>
                        </div>
                    </form>
                </div>
            </h3>


            <div class="clearfix"></div>
        </div>


        <div>
            <div class="row">
                @foreach($examenes as $examen)
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 " style="height: 200px">
                        <a href="{{ url('examenes/'.$examen->id )}}">
                            <div class="tile-stats" style="background: #FFFFFF;">
                                <div class="icon"><i class="fa fa-file-text-o"></i>
                                </div>
                                <div class="count">{{$examen->name}}</div>

                                <h3 style="font-size: 13px" class="list-inline count2">
                                    <b>{{ $examen->display_name }}</b></h3>
                                <div style="overflow-y: hidden; height: 85px"><p>{{ $examen->observation }}</p></div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-12" style="text-align: center">
            {{ $examenes->appends(Request::only(['display_name']))->render() }}
        </div>
    </div>



@endsection

@section('scripts')

@endsection