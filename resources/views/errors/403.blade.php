@extends('layouts.error')

@section('error-number')
    403
@endsection
@section('error-title')
    Acceso denegado
@endsection
@section('error-description')
    ¿Tal vez quiera regresar a la <a href="{{URL::previous()}}">página anterior</a> o la
    <a href="{{route('home')}}">página de inicio</a>?
@endsection