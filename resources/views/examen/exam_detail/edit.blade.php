@extends('layouts.app')

@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url("/css/sumoselect.css")}}">
@endsection
@section('styles')
    <!-- Select2 -->
    <link href="{{url('gentallela/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('examenes')}}">Exámenes</a></li>
            <li>{{$detail? $detail->name_detail:'Nuevo'}}</li>
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

            @if($detail)
                <h2>Editar Resultado</h2>
            @else
                <h2>Registrar Resultado</h2>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{ url('examenes/storedetail') }}"
                  enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="col-md-2"></div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group hidden">
                        <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12"> Id
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$detail? $detail->id:old('id')}}" @if($detail) required @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name_detail" class="control-label col-md-3 col-sm-3 col-xs-12"> Nombre
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name_detail" name="name_detail" class="form-control" placeholder="Nombre del Resultado"
                                   value="{{$detail? $detail->name_detail:old('name_detail')}}" required @if($detail) readonly @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Descripcion <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="descripcion" name="description" class="form-control"
                                   placeholder="Descricion del Resultado"
                                   value="{{$detail? $detail->description:old('description')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estado" class="control-label col-md-3 col-sm-3 col-xs-12"> Estado

                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="estado" name="estado" class="form-control" placeholder="Estado"
                                   value="{{$detail? $detail->estado:old('estado')}}">
                        </div>
                    </div>

                    <div class="form-group" >
                        <label for="reference_type_id" class="control-label col-md-3 col-sm-3 col-xs-12"> Tipo de Resultado
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="reference_type_id" name="reference_type_id" class="form-control" required >
                                @foreach($types as $type)
                                <option value="{{$type->id}}"
                                        @if($detail? $detail->reference_type_id==$type->id:null) selected @endif>{{$type->display_name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" > Agrupamiento:
                            <span class="required">*</span>
                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control"  name="grouping_id" tabindex="-1" required>
                                @foreach($groupings as $grouping)
                                    <option value="{{$grouping->id}}"
                                            @if($detail? $detail->grouping_id==$grouping->id:null) selected @endif
                                    >{{$grouping->display_name}}</option>
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
    <!-- Select2 -->
    <script src="{{url('gentallela/vendors/select2/dist/js/select2.full.min.js')}}"></script>
@endsection
@section('script-codigo')
    <!-- Select2 -->
    <script>
        $(document).ready(function() {
            $(".select2_grupo").select2({
                placeholder: "Seleccione un grupo...",
                allowClear: true
            });
            $(".select2_tipo").select2({
                placeholder: "Seleccione un tipo...",
                allowClear: true
            });
        });
    </script>
    <!-- /Select2 -->
@endsection