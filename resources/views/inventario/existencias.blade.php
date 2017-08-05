@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="x_title">
        <h3 class="pull-left">Existencias de recursos
            {{--<a href="{{ route('activo.reactivo.edit') }}" title="Actualizar existencia" style="float: right">
                                    <div class="btn btn-primary">
                                        <i class="fa fa-bar-chart" aria-hidden="true"></i> Actualizar Existencia
                                    </div>
                                </a>--}}
        </h3>
        <div class="pull-right top_search" style="margin-top: 0.5em">
            <form action="{{route('activo.existencias')}}" method="GET">
                <div class="input-group">
                    <input class="form-control" name="nombre"
                           placeholder="Buscar por nombre...">
                    <span class="input-group-btn">
                      <button class="btn btn-default">Buscar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        @php $count=0 @endphp
        @foreach($recursos as $recurso)
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel tile">
                    <div class="x_title">
                        <h2><a href="{{route('activo.show',$recurso->id)}}">{{$recurso->nombre}}</a></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        @foreach($recurso->inventarios as $inventario)
                            <div class="widget_summary">
                                <div class="w_left w_30">
                                    <span>{{$inventario->sucursal->display_name}}</span>
                                </div>
                                @php
                                    $cantidad=$inventario->existencias()->sum('cantidad');
                                $porcentaje=round(($cantidad/$inventario->maximo)*100);
                                @endphp
                                <div class="w_center w_50">
                                    <div class="progress">
                                        <div class="progress-bar
                                        @if($cantidad>$inventario->minimo) progress-bar-success
                                        @else progress-bar-danger
                                        @endif" role="progressbar" data-transitiongoal="{{$porcentaje}}">
                                        </div>
                                        <span>{{$porcentaje}}%</span>
                                    </div>
                                </div>
                                <div class="w_right w_20">
                                    <span>{{$cantidad}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @php $count+=1 @endphp
            @if($count==3)
                <div class="clearfix"></div>
                @php $count=0 @endphp
            @endif
        @endforeach
        <div class="col-md-12" style="text-align: center">
            {{ $recursos->appends(Request::only(['nombre']))->render() }}
        </div>
    </div>

@endsection

@section('scripts')
    <!-- bootstrap-progressbar -->
    <script src="{{url('gentallela/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
@endsection