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
            <li>Sucursales</li>
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
            <h3>Sucursales
                <a href="{{ url('sucursales/create') }}" title="Crear Nuevo Usuario" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Nueva Sucursal
                    </div>
                </a>
            </h3>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="row">
                @foreach($sucursales as $sucursal)
                    <div class="col-lg-3 col-md-4 col-xs-12 profile_details">
                        <div class="well profile_view col-md-12">
                            <div class="col-sm-12">
                                <h4 class="brief"><i>Sucursal</i></h4>

                                <div class="col-xs-12">
                                    <img alt="TestLab" class="img-sucursal img-responsive" src="
                                    @if($sucursal->imagen)
                                    {{url('/storage/images/'.$sucursal->imagen->file_name)}}
                                    @else
                                    {{url('/storage/images/'.\App\Imagen::getDefaultImage()->file_name)}}
                                    @endif " >
                                </div>
                                <div class="left col-xs-12">
                                    <h2>{{$sucursal->display_name}}</h2>
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-building"></i> Dirección: {{$sucursal->direccion}}</li>
                                        <li><i class="fa fa-phone"></i> Telefono: {{$sucursal->telefono}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-12 bottom">
                                <div class="col-xs-12 emphasis" style="text-align: center">
                                    <a class="btn btn-primary" href="{{url('sucursales/'.$sucursal->id)}}">
                                        <i class="fa fa-eye"> </i> Ver Sucursal
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