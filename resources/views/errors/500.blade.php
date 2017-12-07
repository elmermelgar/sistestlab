@extends('layouts.error')

@section('error-number')
    500
@endsection
@section('error-title')
    Error interno del servidor
@endsection
@section('error-description')
    Intente más tarde. Si el error persiste, por favor contacte al administrador.
    <br>
    ¿Tal vez quiera regresar a la <a href="{{URL::previous()}}">página anterior</a> o la
    <a href="{{route('home')}}">página de inicio</a>?
@endsection