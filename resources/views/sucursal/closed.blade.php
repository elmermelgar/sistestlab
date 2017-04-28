@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Sucursal</li>
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

    <div style="font-size: 20px">
        <i class="fa fa-exclamation-circle" style="color: red"></i>
        No puede facturar en este momento debido a que la caja de la sucursal está cerrada.
        <br>
        Para abrir caja, dirijase a la sucursal haciendo click
        <a href="{{url('sucursal')}}">aquí</a>.
    </div>

@endsection

@section('scripts')
@endsection