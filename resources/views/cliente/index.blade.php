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
            <li>Clientes</li>
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
            <h3>Clientes
                <a href="{{ url('clientes/create') }}" title="Registrar Nuevo Cliente" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Registrar Nuevo Cliente
                    </div>
                </a>
            </h3>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="row">
                @foreach($clientes as $cliente)
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                            <div class="col-xs-12">
                                <h4 class="brief"><i>Cliente</i></h4>
                                <div class="left col-xs-8">
                                    <h2>{{$cliente->razon_social}}</h2>
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-envelope"></i>
                                            {{$cliente->user?$cliente->user->email:'--'}}
                                        </li>
                                        <li><i class="fa fa-building"></i> Dirección: {{$cliente->direccion}}</li>
                                        <li><i class="fa fa-phone"></i> Télefono:{{$cliente->telefono}}</li>
                                    </ul>
                                </div>
                                <div class="right col-xs-4 text-center">
                                    <img src="
                                    @if(isset($cliente->user->photo))
                                    {{url('storage/photos/'. $cliente->user->photo)}}
                                    @else
                                    {{url('storage/photos/user.png')}}
                                    @endif "
                                         alt="cliente" class="img-circle img-responsive">
                                </div>
                            </div>
                            <div class="col-xs-12 bottom text-center">
                                <div class="col-xs-12 col-sm-7 emphasis"></div>
                                <div class="col-xs-12 col-sm-5 emphasis">
                                    <a class="btn btn-primary btn-xs" href="{{url('clientes/'.$cliente->id)}}">
                                        <i class="fa fa-briefcase fa-fw"></i>Ver Perfil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection


@section('scripts')
@endsection