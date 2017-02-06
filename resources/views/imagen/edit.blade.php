@extends('layouts.app')

@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url('gentallela/vendors/iCheck/skins/flat/green.css')}}">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/imagenes')}}">Imagenes</a></li>
            <li>{{$imagen? $imagen->title:'Subir Imagen'}}</li>
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

            @if($imagen)
                <h2>Modificar Imagen</h2>
            @else
                <h2>Subir Imagen</h2>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{url('imagenes/store')}}"
                  enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="col-md-12 col-sm-12 col-xs-12 profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar form-group">
                            <!-- Current avatar -->
                            <img src="{{$imagen? '/storage/images/'.$imagen->file_name:null}}"
                                 class="img-responsive avatar-view" style="max-height: 250px; margin-bottom: 1em">
                            @if(isset($new))
                                <i id="faimage" class="fa fa-image" style="font-size: 15em"></i>
                                <br>
                                <label for="image" id="imageLabel" class="hidden">Seleccionar Imagen</label>
                                <input type="file" id="image" name="image" maxlength="255" accept=".png,.jpg,.jpeg"
                                       required>
                                <p>*El tamaño máximo por archivo es: 2M</p>
                                <p>*Resolución recomendada para logos: 700x200</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-6 col-xs-12">
                    <div class="form-group hidden">
                        <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12"> Id
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$imagen? $imagen->id:old('id')}}" @if($imagen) required @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title"> Titulo de imagen
                            <span class="required">*</span>
                        </label>
                        <div>
                            <input id="title" name="title" class="form-control" placeholder="Titulo"
                                   value="{{$imagen? $imagen->title:old('title')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description"> Descripción
                            <span class="required">*</span>
                        </label>
                        <div>
                            <textarea id="description" name="description" class="form-control" placeholder="Descripción"
                                      required>{{$imagen? $imagen->description:old('description')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label style="padding-left: 0">
                                <input type="checkbox" id="default" name="default" class="flat"
                                       @if($imagen? $imagen->default:null) checked @endif> Imagen por defecto
                            </label>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">

                        <div class="col-md-offset-2 col-md-5 col-sm-5 col-xs-12">
                            <a href="{{url()->previous()}}" class="form-control btn btn-default">Cancelar</a>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="submit" class="form-control btn btn-primary"
                                   value="{{$imagen? 'Guardar':'Subir Imagen'}}">
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/iCheck/icheck.min.js')}}"></script>
    @if(isset($new))
        <script src="{{url('/js/avatar.js')}}"></script>
        <script>
            $(document).ready(function () {
                $('#image').change(previewAvatar)
            });
        </script>
    @endif
@endsection