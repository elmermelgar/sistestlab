@extends('layouts.app')

@section('imports')

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/bonos')}}">Bonos</a></li>
            <li>{{$bono? $bono->name:'Nuevo'}}</li>
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

            @if($bono)
                <h2>Editar Bono</h2>
            @else
                <h2>Registrar Bono</h2>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{url('bonos/store')}}">
                {{csrf_field()}}

                <div class="col-md-9 col-sm-9 col-xs-12" style="margin: 0 auto;float: none">
                    <div class="form-group hidden">
                        <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12"> Id
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$bono? $bono->id:old('id')}}" @if($bono) required @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="monto" class="control-label col-md-3 col-sm-3 col-xs-12"> Monto
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" id="monto" name="monto" class="form-control" placeholder="USD"
                                   min="0" step="0.01"
                                   value="{{$bono? $bono->monto:old('monto')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="control-label col-md-3 col-sm-3 col-xs-12"> Descripción
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="descripcion" name="descripcion" class="form-control resize"
                                      placeholder="Descripción" maxlength="255"
                            >{{$bono? $bono->descripcion:old('descripcion')}}</textarea>
                        </div>
                    </div>

                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="ln_solid"></div>
                    <div class="form-group">

                        <div class="col-md-offset-4 col-md-2 col-sm-2 col-xs-12">
                            <a href="{{url()->previous()}}" class="form-control btn btn-default">Cancelar</a>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <input type="submit" class="form-control btn btn-primary" value="Guardar">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection

@section('scripts')

@endsection