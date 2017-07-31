@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{route('activo.index')}}">Activos</a></li>
            <li><a href="{{route('activo.show',$activo->id)}}">{{$activo->nombre}}</a></li>
            <li>Inventario</li>
            <li class="alignright no-before">
                <a href="{{URL::previous()}}" class="btn btn-danger btn-sm">
                    <i class="fa fa-reply-all fa-fw"></i>Regresar</a>
            </li>
        </ol>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Actualizando inventario del activo {{$activo? $activo->nombre_activo:'Inventario'}}
                        <i class="text-danger">{{$activo? $activo->nombre:'Inventario'}}</i>
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <p>Seleccione una sucursal y de clic en agregar para asociar el activo con dicha sucursal</p>

                    <form id="add" class="form form-inline">
                        <div class="col-sm-8 col-xs-12" style="margin-bottom: 1em">
                            <div class="form-group">
                                <label for="sucursal_add">Sucursal:</label>
                                <select id="sucursal_add" name="sucursal_add" class="form-control" required>
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{$sucursal->id}}"
                                                @if(in_array($sucursal->id,$selected)) disabled
                                                @endif>{{$sucursal->display_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group hidden">
                                <label for="estado_add">Estado:</label>
                                <select id="estado_add" class="form-control" style="width:100%">
                                    @foreach($estados as $estado)
                                        <option value="{{$estado->id}}"
                                                @if($activo&&$estado->id==$activo->estado_id) selected
                                                @endif>{{$estado->display_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="submit" class="btn btn-default" style="margin: 0" value="Agregar">
                        </div>
                    </form>

                    <form class="form form-inline" method="POST"
                          action="{{route('activo.update_inventario',$activo->id)}}">
                        {{ csrf_field() }}
                        <div class="form-group hidden">
                            <input type="hidden" readonly required name="activo_id" value="{{$activo->id}}">
                        </div>
                        <table id="inventario" class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Sucursal&emsp;&emsp;</th>
                                <th data-sorting="false">Estado&emsp;&emsp;</th>
                                <th data-sorting="false">Ubicación&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>
                                <th data-sorting="false">Cantidad mínima</th>
                                <th data-sorting="false">Cantidad máxima</th>
                                <th data-sorting="false">Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inventarios as $inventario)
                                <tr>
                                    <td>{{$inventario->sucursal->display_name}}
                                        <input type="hidden" name="sucursal_id[]" class="sucursal" required
                                               value="{{$inventario->sucursal_id}}">
                                    </td>
                                    <td>
                                        <select name="estado_id[]" class="form-control" style="width: 100%">
                                            @foreach($estados as $estado)
                                                <option value="{{$estado->id}}"
                                                        @if($estado->id==$inventario->estado_id) selected
                                                        @endif>{{$estado->display_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input name="ubicacion[]" class="form-control" style="width: 100%"
                                               placeholder="¿Dónde está ubicado?" required maxlength="255"
                                               value="{{$inventario->ubicacion}}">
                                    </td>
                                    <td>
                                        <input type="number" name="minimo[]" class="form-control" style="width: 100%"
                                               placeholder="0" required min="1" value="{{$inventario->minimo}}">
                                    </td>
                                    <td>
                                        <input type="number" name="maximo[]" class="form-control" style="width: 100%"
                                               placeholder="100" required min="1" value="{{$inventario->maximo}}">
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
                                <a class="btn btn-default" href="{{URL::previous()}}">Cancelar</a>
                                <button class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('js/inventario.js')}}"></script>
@endsection
