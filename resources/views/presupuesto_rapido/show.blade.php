@extends('layouts.app')

@section('imports')
    <link href="{{url('css/quick-budget.css')}}" rel="stylesheet">
@endsection

@section('styles')

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
            <li>Presupuesto rápido</li>
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
        <div class="col-sm-10">
            <h3>Presupuesto rápido</h3>
            @include('presupuesto_rapido.budget')
        </div>
        <div class="col-sm-2">
            <br><br><br>
            <a href="{{route('presupuesto_rapido.edit')}}" id="edit" class="btn btn-default form-control">
                <i class="fa fa-edit"></i> Editar</a>
            <br><br>
            <a href="{{route('presupuesto_rapido.pdf')}}" id="pdf" class="btn btn-primary form-control" target="_blank">
                <i class="fa fa-file-pdf-o"></i> PDF para imprimir</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var params = new URLSearchParams(window.location.search);
        document.getElementById("edit").href += '?' + params;
        document.getElementById("pdf").href += '?' + params;
    </script>
@endsection