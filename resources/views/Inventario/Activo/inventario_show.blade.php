@extends('layouts.app')

@section('imports')

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ route('activo.index')}}">Activos</a></li>
            <li>{{$activo->nombre_activo}}</li>
        </ol>
        <a href="{{route('activo.index')}}" style="float: right; margin-top: -50px; margin-right: 20px; font-size: 9px" class="btn btn-dark"><i class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>

    </div>


    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h3>@if($activo->tipo == "equipo")Activo: @else Reactivo: @endif {{$activo->nombre_activo}}</h3>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-4 col-sm-4 col-xs-12 profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <!-- Current avatar -->
                            <img class="img-responsive avatar-view" alt="Inventario" title="Inventario"
                                 style="max-height: 100%"
                                 src="{{url('/storage/images/'. 'inventario.png')}}">
                        </div>
                    </div>
                    <br/>
                    <a class="btn btn-primary" style="width: 100%" href="{{route('activo.edit',$activo->id)}}">
                        <i class="fa fa-edit m-right-xs"></i> Editar @if($activo->tipo == "reactivo")Reactivo @else Activo @endif</a>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <h4>{{$activo->nombre_activo}}</h4>

                    <ul class="list-unstyled user_data">

                        <li><i class="fa fa-calendar user-profile-icon"></i>
                            Fecha de aquicisión: <strong>{{$activo->fecha_adq}}</strong>
                        </li>
                        <li><i class="fa fa-usd user-profile-icon"></i>
                            Precio: <strong>${{$activo->precio}}</strong>
                        </li>
                        <li><i class="fa fa-map-marker user-profile-icon"></i>
                            Sucursal: <strong>{{$activo->sucursal->display_name}}</strong>
                        </li>
                        <li><i class="fa fa-location-arrow user-profile-icon"></i>
                            Ubicación: <strong>{{$activo->ubicacion}}</strong>
                        </li>
                        <li><i class="fa fa-chevron-right user-profile-icon"></i>
                            Tipo: <strong>@if($activo->tipo == "reactivo")Reactivo @else Moviliario y Equipo @endif</strong>
                        </li>
                        <li><i class="fa fa-male user-profile-icon"></i>
                            Proveedor: <strong>{{$activo->proveedor->nombre}}</strong>
                        </li>
                        @if($activo->tipo == "reactivo")
                        <li><i class="fa fa-thermometer-half user-profile-icon"></i>
                            Unidades: <strong>{{$activo->unidades}}</strong>
                        </li>
                        @endif
                        <li><i class=" user-profile-icon"></i>
                            Marca: <strong>{{$activo->marca}}</strong>
                        </li>
                        <li><i class=" user-profile-icon"></i>
                            Lote: <strong>{{$activo->num_lote}}</strong>
                        </li>
                        <li><i class=" user-profile-icon"></i>
                            Modelo: <strong>{{$activo->modelo}}</strong>
                        </li>
                        <li><i class=" user-profile-icon"></i>
                            Serie: <strong>{{$activo->serie}}</strong>
                        </li>
                    </ul>
                    <br/>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h4>Inventario</h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th><i class="fa fa-lock user-profile-icon"></i>
                            Código de inventario: </th>
                        <td><strong>{{$activo->cod_inventario}}</strong></td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>
                            <span class="badge bg-info">@if($activo->estado_id){{$activo->estado->display_name}}@else Sin Estado @endif</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Existencia:</th>
                        <td>{{$inventario->existencia}}</td>
                    </tr>
                    <tr>
                        <th>Cantidad Mínima:</th>
                        <td>{{$inventario->cantidad_minima}}</td>
                    </tr>
                    <tr>
                        <th>Cantidad Máxima:</th>
                        <td>{{$inventario->cantidad_maxima}}</td>
                    </tr>
                    <tr>
                        <th>Fecha de última carga:</th>
                        <td>{{$carga}}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Vencimiento:</th>
                        <td>{{$vence}}</td>
                    </tr>
                    <tr>
                        <th>Última actualización:</th>
                        <td>{{$activo->updated_at}}</td>
                    </tr>
                    </tbody>
                </table>
                <button  class="btn btn-round btn-success" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-upload" aria-hidden="true"> </i> Cargar Inventario</button>
                <a href="{{route('activo.editinventario',[$inventario->id,$activo->id])}}" style="float: right; " class="btn btn-round btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Inventario</a>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h2>Observaciones</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h4>Este Inventario no posee observaciones:</h4>

            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Cargar Existencias</h4>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('cargar.updateinventario',[$inventario->id,$activo->id])}}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        {{--Parte 1--}}
                        <fieldset>
                            <legend class="text-danger" style="text-align: center">{{$activo->nombre_activo}}</legend>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12" >Cantidad a cargar:
                                    </label>
                                    <br/>

                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="number" name="cantidad" placeholder="0"
                                               class="form-control col-md-7 col-xs-12" min="1" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12" >Fecha Vencimiento:
                                    </label>
                                    <br/>

                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="text" id="vencimiento" name="fecha_vencimiento" class="date-picker form-control col-md-7 col-xs-12" placeholder="00/00/0000">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Cargar al inventario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection