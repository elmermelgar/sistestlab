@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('css/quick-budget.css')}}" rel="stylesheet">
@endsection

@section('styles')

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
            <li>Presupuesto rápido</li>
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

    <div class="row">
        <div class="col-sm-10">
            <h3>Presupuesto rápido</h3>
            <div class="x_panel quick-budget">
                <div class="x_content">
                    @include('presupuesto_rapido.title')
                    <div class="col-sm-12">


                        <h4>PRESUPUESTO RÁPIDO</h4>
                        <p>Fecha: {{\Carbon\Carbon::now()->format('d/m/Y')}}</p>
                        <p>Cajero: {{$cajero? $cajero->first_name:'-'}}</p>

                        <form id="add">
                            <div class="form-group">
                                <label for="perfil_add" class="col-sm-1 control-label">Perfiles:</label>
                                <div class="col-sm-6 col-sm-offset-1 col-md-offset-0">
                                    <select id="perfil_add" class="form-control" style="width: 100%">
                                        @foreach($perfiles as $perfil)
                                            <option value="{{$perfil->id}}"
                                                    @if(in_array($perfil->id,$params['perfiles']))
                                                    disabled
                                                    @endif > {{$perfil->name.' - '.$perfil->display_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-default">Añadir examen</button>
                                </div>
                            </div>
                        </form>

                        <br>
                        <form method="get" action="{{route('presupuesto_rapido.show')}}">
                            <table id="budget" class="table table-condensed">
                                <thead>
                                <tr>
                                    <th data-sortable="false">#</th>
                                    <th data-sortable="true">Examen o perfil</th>
                                    <th data-sortable="false">Cantidad</th>
                                    <th data-sortable="false">Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $cantidades=$params['cantidades'];@endphp
                                @foreach($params['perfiles'] as $perfil_id)
                                    @php $perfil=$perfiles->find($perfil_id);@endphp
                                    <tr>
                                        <td></td>
                                        <td>{{$perfil->name.' - '.$perfil->display_name}}
                                            <input type="hidden" name="perfiles[]" class="sucursal" required
                                                   value="{{$perfil_id}}">
                                        </td>
                                        <td>
                                            <input type="number" name="cantidades[]" class="form-control" style="width: 100%"
                                                   placeholder="0" required min="1" value="{{$cantidades[$loop->index]}}">
                                        </td>
                                        <td>
                                            <div class='btn btn-danger delete'><i class='fa fa-times'></i></div>
                                        </td>
                                @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="form-group">
                                <label for="cliente" class="col-sm-1 control-label">Cliente:</label>
                                <div class="col-sm-6 col-sm-offset-1 col-md-offset-0">
                                    <input id="cliente" name="cliente" class="form-control" placeholder="Digite el nombre del cliente"
                                           value="{{$params['cliente']}}">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary">Visualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('js/quick-budget.js')}}"></script>
@endsection