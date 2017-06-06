@extends('layouts.app')

@section('imports')
    <link rel="stylesheet" type="text/css" href="{{url("/css/sumoselect.css")}}">
    <link rel="stylesheet" type="text/css" href="{{url('gentallela/vendors/iCheck/skins/flat/green.css')}}">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            {{--<li><a href="">Examenes</a></li>--}}
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

            @if($examen_activo)
                <h2>Editar Recursos</h2>
            @else
                <h2>Registrar Recursos</h2>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left" method="post" action="{{url('examenes/store_examen_activo')}}">
                {{csrf_field()}}

                <div class="col-md-9 col-sm-9 col-xs-12" style="margin: 0 auto;float: none">
                    <div class="form-group hidden">
                        <label for="id" class="control-label col-md-3 col-sm-3 col-xs-12"> Id
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="id" name="id" class="form-control" placeholder="ID"
                                   value="{{$examen_activo? $examen_activo->id:old('id')}}" >
                        </div>
                    </div>
                    <div class="form-group hidden">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="exam_id" name="exam_id" class="form-control" placeholder="ID"
                                   value="{{$examen? $examen->id:old('id')}}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cliente_id" class="control-label col-md-3 col-sm-3 col-xs-12"> Recurso
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select multiple id="activo_id" name="activo_id[]" class="form-control" required>
                                @foreach($activos as $activo)
                                    <option value="{{$activo->id}}"
                                            @if($examen? $examen->activos->find($activo->id):null) selected @endif>{{$activo->nombre_activo}}
                                    </option>
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
    <script src="{{url("/js/sumoselect.min.js")}}"></script>
    <script src="{{url('gentallela/vendors/iCheck/icheck.min.js')}}"></script>
    <script src="{{url('js/moment-with-locales.min.js')}}"></script>
    <script type="application/javascript">
        moment.locale('es');
        $(document).ready(function(){
            $('#activo_id').SumoSelect({search: true, placeholder: 'Seleccione el recurso a asociar'});
            Inputmask().mask(document.querySelectorAll("input"));
        });
    </script>
@endsection