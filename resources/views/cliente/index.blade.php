@extends('layouts.app')

@section('styles')
    <style>
        .profile_details {
            clear: inherit !important;
        }

        .tab a:hover {
            background-color: #eee !important;
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Clientes</li>
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

    <ul id="myTab" class="nav nav-tabs">
        <li @if(!isset($origen)) class="active" @else class="tab" @endif>
            <a class="tab" href="{{url('clientes')}}">Clientes</a>
        </li>
        <li @if(isset($origen)) class="active" @else class="tab" @endif>
            <a href="{{url('origenes')}}">Centros de Origen</a>
        </li>
        <li style="float: right">
            <a href="{{ url('clientes/create') }}" title="Registrar Nuevo Cliente" style="padding: 0">
                <div class="btn btn-primary" style="margin: 0">
                    <i class="fa fa-user-plus"></i> Registrar Nuevo Cliente
                </div>
            </a>
        </li>
        <li style="float: right">
            <div class="pull-right top_search" style="margin-right: 5%">
                <form action="@if(isset($origen)) {{url('origenes')}} @else {{url('clientes')}} @endif" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="name"
                               placeholder="Buscar por razón social...">
                        <span class="input-group-btn">
                      <button class="btn btn-default">Buscar</button>
                    </span>
                    </div>
                </form>
            </div>
        </li>

    </ul>
    <div class="alignright">

    </div>

    <div class="x_panel" style="border-top: none">

        <div class="x_content">
            <div class="row">
                @php $count=0 @endphp
                @forelse($clientes as $cliente)
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                            <div class="col-xs-12">
                                <h4 class="brief">
                                    <i>@if($cliente->origin_center)
                                            Centro de Origen
                                        @else
                                            Cliente
                                        @endif
                                    </i>
                                </h4>
                                <div class="left col-xs-8">
                                    <h2>{{$cliente->name}}</h2>
                                    <p style="color: #0b97c4"><strong>{{$cliente->trade_name}}</strong></p>
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-envelope"></i>
                                            {{$cliente->account->user?$cliente->account->user->email:'--'}}
                                        </li>
                                        <li><i class="fa fa-building"></i> Dirección: {{$cliente->address}}</li>
                                        <li><i class="fa fa-phone"></i> Télefono:{{$cliente->phone_number}}</li>
                                    </ul>
                                </div>
                                <div class="right col-xs-4 text-center">
                                    <img src="
                                    @if(isset($cliente->account->photo))
                                    {{url('storage/photos/'. $cliente->account->photo)}}
                                    @else
                                    {{url('storage/photos/user.png')}}
                                    @endif "
                                         alt="cliente" class="img-circle img-responsive">
                                </div>
                            </div>
                            <div class="col-xs-12 bottom" style="text-align: center">
                                <div class="col-xs-12 emphasis">
                                    <a class="btn btn-primary" href="{{route('customer.show',$cliente->id)}}">
                                        <i class="fa fa-eye fa-fw"></i> Ver Perfil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $count+=1 @endphp
                    @if($count==3)
                        <div class="clearfix"></div>
                        @php $count=0 @endphp
                    @endif
                @empty
                    Sin registros!
                @endforelse
                <div class="col-md-12" style="text-align: center">
                    {{ $clientes->appends(Request::only(['nombre']))->render() }}
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
@endsection