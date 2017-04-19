@extends('layouts.app')

@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url("/css/sumoselect.css")}}">
    <link rel="stylesheet" type="text/css"
          href="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.css')}}">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            {{--<li><a href="{{url('/examenes/'.$examen->sucursal_id)}}">Exámenes</a></li>--}}
            {{--<li>{{$examen? $examen->display_name:'Nuevo'}}</li>--}}
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

            @if($examen)
                <h2>Editar Exámen</h2>
            @else
                <h2>Registrar Exámen</h2>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{url('examenes')}}"
                  enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img">
                        <input type="hidden" id="id" name="sucursal_id" class="form-control" placeholder="ID"
                               value="{{ $sucursal->id }}" >
                    </div>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group hidden">
                        <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12"> Id
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$examen? $examen->id:old('id')}}" @if($examen) required @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="razon_social" class="control-label col-md-3 col-sm-3 col-xs-12"> Código
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" name="name" class="form-control" placeholder="Código"
                                   value="{{$examen? $examen->name:old('name')}}" required @if($examen) readonly @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre_examen" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Nombre del Exámen <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="nombre_examen" name="display_name" class="form-control"
                                   placeholder="Nombre del examen"
                                   value="{{$examen? $examen->display_name:old('display_name')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="precio" class="control-label col-md-3 col-sm-3 col-xs-12"> Precio
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" step="any"  id="precio" name="precio" class="form-control" placeholder="Precio"
                                   value="{{$examen? $examen->precio:old('precio')}}" required >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="observation" class="control-label col-md-3 col-sm-3 col-xs-12"> Descripción
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="observation" name="observation" class="form-control" placeholder="Descripción"
                                   value="{{$examen? $examen->observation:old('observation')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="material_directo" class="control-label col-md-3 col-sm-3 col-xs-12"> Material directo</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" step="any"  id="material_directo" name="material_directo" class="form-control" placeholder="Material directo"
                                   value="{{$examen? $examen->material_directo:old('material_directo')}}" required>
                        </div>
                    </div>

                    <div class="form-group" id="div_nombre">
                        <label for="mano_obra" class="control-label col-md-3 col-sm-3 col-xs-12"> Mano de obra</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" step="any"  id="mano_obra" name="mano_obra" class="form-control" placeholder="Mano de obra"
                                   value="{{$examen? $examen->mano_obra:old('mano_obra')}}" required>
                        </div>
                    </div>
                    <div class="form-group" id="div_apellido">
                        <label for="cif" class="control-label col-md-3 col-sm-3 col-xs-12"> CIF</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" step="any"  id="cif" name="cif" class="form-control" placeholder="Costos Indirectos de fabricación"
                                   value="{{$examen? $examen->cif:old('cif')}}" required>
                        </div>
                    </div>

                    <div class="form-group" id="div_genero">
                        <label for="genero" class="control-label col-md-3 col-sm-3 col-xs-12"> Tipo de Muestra
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="sample" name="sample_id" class="form-control" required >
                                @foreach($samples as $sample)
                                <option value="{{$sample->id}}"
                                        @if($examen? $examen->sample_id==$sample->id:null) selected @endif>{{$sample->display_name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" > Estado:
                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_estado form-control" name="estado_id" tabindex="-1">
                                @foreach($estados as $estado)
                                    <option value="{{$estado->id}}"
                                            @if($examen? $examen->estado_id==$estado->id:null) selected @endif
                                    >{{$estado->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" > Categoría:
                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_category form-control" name="exam_category_id" tabindex="-1">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"
                                            @if($examen? $examen->exam_category_id==$category->id:null) selected @endif
                                            >{{$category->name}}</option>
                                @endforeach
                            </select>
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
    <script src="{{url('/js/avatar.js')}}"></script>
    <script src="{{url('/js/paciente.js')}}"></script>
    <script src="{{url('/js/moment-with-locales.min.js')}}"></script>
    <script type="application/javascript">
        moment.locale('es');
    </script>
    <script src="{{url('gentallela/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
@endsection