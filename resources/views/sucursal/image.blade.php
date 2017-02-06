@extends('layouts.app')

@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url('gentallela/vendors/iCheck/skins/flat/green.css')}}">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('sucursales')}}">Sucursales</a></li>
            <li><a href="{{url('sucursales/'.$sucursal->id)}}">{{$sucursal->display_name}}</a></li>
            <li>Cambiar Imágen</li>
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

            <h2>Cambiar Imágen de Sucursal</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{url('sucursales/image')}}"
                  enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="form-group hidden">
                    <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12"> Id
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="id" name="id" class="form-control" placeholder="ID"
                               value="{{$sucursal? $sucursal->id:old('id')}}" required>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    @foreach($imagenes as $imagen)

                        <div class="col-md-4 col-sm-4 col-xs-12" >
                            <div class="form-group" style="border:dashed">
                                <label for="image"></label>
                                <img src="{{$imagen? '/storage/images/'.$imagen->file_name:null}}"
                                     class="img-responsive avatar-view"
                                     style="max-height: 250px; margin-bottom: 1em">
                                <input type="radio" id="image" name="image" class="form-control" required
                                       value="{{$imagen->id}}">
                            </div>
                        </div>

                    @endforeach
                </div>

                <div class="col-md-12">
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-2 col-sm-2 col-xs-12">
                            <a href="{{url()->previous()}}" class="form-control btn btn-default">Cancelar</a>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <input type="submit" class="form-control btn btn-primary"
                                   value="Guardar">
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/iCheck/icheck.min.js')}}"></script>
@endsection