@extends('layouts.app')

@section('imports')
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                    <h2>Bienvenido</h2>
                    Usted ha iniciado sesión correctamente!
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel
    ================================================== -->
    <div id="carousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @foreach($publicidades as $publicidad)
                <li data-target="#carousel" data-slide-to="{{$loop->index}}"
                    @if($loop->first) class="active" @endif ></li>
            @endforeach
        </ol>
        <div class="carousel-inner" role="listbox">
            @foreach($publicidades as $publicidad)
                <div class="item @if($loop->first) active @endif">
                    <img src="{{url("storage/images/$publicidad->file_name")}}" alt="publicidad">
                </div>
            @endforeach
        </div>
        <a class="left carousel-control" href="#carousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="right carousel-control" href="#carousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Siguiente</span>
        </a>
    </div><!-- /.carousel -->


@endsection
