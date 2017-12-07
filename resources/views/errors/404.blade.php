@extends('layouts.error')

@section('error-number')
    404
@endsection
@section('error-title')
    Lo sentimos pero no hemos podido encontrar esta página
@endsection
@section('error-description')
    ¿Tal vez quiera regresar a la <a href="{{URL::previous()}}">página anterior</a> o la
    <a href="{{route('home')}}">página de inicio</a>?
@endsection