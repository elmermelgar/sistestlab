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
            <h3>Administración de Recursos
                {{--<a href="{{ url('sucursales/create') }}" title="Crear Nuevo Usuario" style="float: right">--}}
                    {{--<div class="btn btn-primary">--}}
                        {{--<i class="fa fa-user-plus" aria-hidden="true"></i> Nueva Sucursal--}}
                    {{--</div>--}}
                {{--</a>--}}
            </h3>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="row">
                    @foreach($sucursales as $sucursal)
                    <div class="col-md-4  widget widget_tally_box">
                        <div class="x_panel fixed_height_390">
                            <div class="x_content">

                                <div class="flex">
                                    <ul class="list-inline widget_profile_box">
                                        <li>
                                            {{--<a>--}}
                                                {{--<i class="fa fa-facebook"></i>--}}
                                            {{--</a>--}}
                                        </li>
                                        <li>
                                            {{--<img src="images/user.png" alt="..." class="img-circle profile_img">--}}
                                            <img alt="TestLab" class="img-sucursal img-responsive" src="
                                            @if($sucursal->imagen)
                                            {{url('/storage/images/'.$sucursal->imagen->file_name)}}
                                            @else
                                            {{url('/storage/images/'.\App\Imagen::getDefaultImage()->file_name)}}
                                            @endif " >
                                        </li>
                                        <li>
                                            {{--<a>--}}
                                                {{--<i class="fa fa-twitter"></i>--}}
                                            {{--</a>--}}
                                        </li>
                                    </ul>
                                </div>

                                <h3 class="name">{{$sucursal->display_name}}</h3>

                                <div class="flex">
                                    <ul class="count2" style="text-align: center">
                                        <a href="{{url('examenes/'.$sucursal->id)}}" type="button" class="btn btn-round btn-success">Administración de Exámenes</a>
                                    </ul>
                                </div>
                                <div class="flex">
                                    <ul class="count2" style="text-align: center">
                                        <a href="{{url('examenes/'.$sucursal->id)}}" type="button" class="btn btn-round btn-dark">Administración de Recursos</a>
                                    </ul>
                                </div>
                                <p>
                                    Dirección: {{$sucursal->direccion}}
                                </p>
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