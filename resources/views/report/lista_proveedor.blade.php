@extends('layouts.app')

@section('imports')
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ route('report') }}">Reportes</a></li>
            <li>Lista de proveedores</li>
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

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Lista de proveedores</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <p>Lista de proveedores.</p>
                    <form method="POST" action="{{route('report.lista_proveedor')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <p>No requiere parámetros.</p>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <button type="submit" formtarget="_blank" class="btn btn-primary" value="">
                                Generar Reporte
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
@endsection