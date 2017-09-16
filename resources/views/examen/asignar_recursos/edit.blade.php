@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('examenes')}}">Exámenes</a></li>
            <li><a href="{{url('examenes/'.$examen->id)}}">{{$examen->name.' - '.$examen->display_name}}</a></li>
            <li>Recursos</li>
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
            <h2>Asignar recursos a examen <i style="color: #761c19">{{$examen->name.' - '.$examen->display_name}}</i>
            </h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form id="add" class="form form-inline">
                <div class="col-sm-8 col-xs-12" style="margin-bottom: 1em">
                    <div class="form-group">
                        <label for="activo_add">Recurso:</label>
                        <select id="activo_add" name="activo_add" class="form-control" required>
                            @foreach($activos as $activo)
                                <option value="{{$activo->id}}"
                                        @if(in_array($activo->id,$selected)) disabled
                                        @endif>{{$activo->nombre}} ({{$activo->unidades}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="submit" class="btn btn-default" style="margin: 0" value="Agregar">
                </div>
            </form>

            <form class="form form-inline" method="POST" action="{{url('examenes/store_examen_activo')}}">
                {{ csrf_field() }}
                <div class="form-group hidden">
                    <input type="hidden" readonly required name="exam_id" value="{{$examen->id}}">
                </div>
                <table id="recursos" class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Activo</th>
                        <th>Cantidad</th>
                        <th data-sorting="false">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($examen->activos as $activo)
                        <tr>
                            <td>{{$activo->nombre}}
                                <input type="hidden" name="activo_id[]" class="activo" required
                                       value="{{$activo->id}}">
                            </td>
                            <td>
                                <input type="number" name="cantidad[]" class="form-control" style="width: 100%"
                                       placeholder="0" required min="1" value="{{$activo->pivot->cantidad}}">
                            </td>
                            <td>
                                <div class='btn btn-danger delete'><i class='fa fa-times'></i></div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="ln_solid"></div>
                <div class="col-md-12" style="text-align: center">
                    <div class="form-group">
                        <a class="btn btn-default"
                           href="{{route('examenes.detail',$examen->id)}}">Cancelar</a>
                        <button class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/select2/dist/js/select2.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('js/recurso.js')}}"></script>
@endsection