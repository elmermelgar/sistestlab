@extends('layouts.app')

@section('imports')
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/sucursales')}}">Sucursales</a></li>
            <li><a href="{{url("sucursales/$sucursal->id")}}">{{$sucursal->display_name}}</a></li>
            <li>Registro</li>
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
            <h3>Sucursal {{$sucursal->display_name}} </h3>
            <h2>Registro de caja</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            @include('sucursal.registry_detail')
            <div class="col-md-12" style="text-align: center">
                {{ $registros->links() }}
            </div>
        </div>
    </div>

@endsection

@section('scripts')
@endsection