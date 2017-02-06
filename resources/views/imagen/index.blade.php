@extends('layouts.app')

@section('imports')
    <link href="{{url('css/modalimage.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Imagenes</li>
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
            <h3>Imagenes
                <a href="{{ url('imagenes/upload') }}" title="Subir nueva imagen" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-image" aria-hidden="true"></i> Subir una Imagen
                    </div>
                </a>
            </h3>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="row">

                @forelse($imagenes as $imagen)
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="thumbnail">
                            <div class="image view view-first">
                                <img class="img-responsive" src="{{url('/storage/images/'.$imagen->file_name)}}"
                                     alt="{{$imagen->description}}"/>
                                <div class="mask no-caption">
                                    <div class="tools tools-bottom">
                                        <a class="pointer"
                                           onclick="imgModal('{{$imagen->file_name}}','{{$imagen->description}}')">
                                            <i class="fa fa-eye"></i></a>
                                        <a class="pointer" href="{{url('imagenes/'.$imagen->id).'/edit'}}">
                                            <i class="fa fa-pencil"></i></a>
                                        @if(!$imagen->default)
                                            <a class="pointer"
                                               onclick="imgModalDel('{{$imagen->id}}','{{$imagen->file_name}}','{{$imagen->title}}')">
                                                <i class="fa fa-times"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="caption">
                                <p><strong>{{$imagen->title}}</strong></p>
                                <p><i class="fa fa-comment"></i> {{$imagen->description}}</p>
                                <p><i class="fa fa-calendar"></i> {{$imagen->created_at}}</p>
                                @if($imagen->default)
                                    <i class="badge bg-blue-sky">Imagen por Defecto</i>
                                @endif
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-md-12">
                        Sin imagenes!
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="imgModal" class="modal">
        <!-- The Close Button -->
        <span class="close" onclick="document.getElementById('imgModal').style.display='none'">&times;</span>
        <!-- Modal Content (The Image) -->
        <img src="" class="img-responsive modal-content" id="img">
        <!-- Modal Caption (Image Text) -->
        <strong id="caption" class="img-caption"></strong>
    </div>

    <!-- The Modal -->
    <div id="imgModalDel" class="modal">
        <!-- The Close Button -->
        <span class="close" onclick="document.getElementById('imgModalDel').style.display='none'">&times;</span>
        <!-- Modal Content (The Image) -->
        <img src="" class="img-responsive modal-delete-content" id="imgDel">
        <!-- Modal Caption (Image Text) -->
        <strong id="captionDel" class="img-caption"></strong>


        <div class=" col-md-6 col-md-offset-3">
            <form method="post" action="{{url('imagenes/delete')}}">
                {{csrf_field()}}
                <div class="form-group hidden">
                    <label for="id"> Id
                        <span class="required">*</span>
                    </label>
                    <div>
                        <input id="id" name="id" class="form-control" placeholder="ID" value="" required>
                    </div>
                </div>
                <div class="form-group  img-caption">
                    <div class="form-group col-md-12">
                        <strong>¿Está seguro de eliminar la imagen?</strong>
                    </div>
                    <div class="col-md-4 col-md-offset-2">
                        <a class="btn btn-default form-control"
                           onclick="document.getElementById('imgModalDel').style.display='none'">Cancelar</a>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" class="btn btn-danger form-control" value="Eliminar">
                    </div>
                </div>
            </form>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="{{url('js/modalimage.js')}}"></script>
@endsection