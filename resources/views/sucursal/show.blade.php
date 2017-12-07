@extends('layouts.app')

@section('imports')
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/sucursales')}}">Sucursales</a></li>
            <li>{{$sucursal->display_name}}</li>
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
        <div class="col-sm-7 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <h3>Sucursal {{$sucursal->display_name}}</h3>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="col-sm-5 col-xs-12">
                        <img class="img-sucursal img-responsive"
                             src="
                         @if($sucursal->imagen)
                             {{url('storage/images/'.$sucursal->imagen->file_name)}}
                             @else
                             {{url('storage/images/'.\App\Imagen::getDefaultImage()->file_name)}}
                             @endif">
                    </div>

                    <div class="col-sm-7 col-xs-12">
                        <ul class="list-unstyled user_data">
                            <li><i class="fa fa-id-card user-profile-icon"></i>
                                Nombre: <strong>{{$sucursal->name}}</strong>
                            </li>
                            <li><i class="fa fa-id-card user-profile-icon"></i>
                                Nombre para mostrar: <strong>{{$sucursal->display_name}}</strong>
                            </li>
                            <li><i class="fa fa-bank user-profile-icon"></i>
                                Dirección: <strong>{{$sucursal->direccion}}</strong>
                            </li>
                            <li><i class="fa fa-phone user-profile-icon"></i>
                                Telefono: <strong>{{$sucursal->telefono}}</strong>
                            </li>
                            <li><i class="fa fa-calendar user-profile-icon"></i>
                                Registrada en: <strong>{{$sucursal->created_at}}</strong>
                            </li>
                        </ul>

                        @permission('admin_sucursales')
                        <a class="btn btn-primary" href="{{url('sucursales/'.$sucursal->id.'/edit')}}">
                            <i class="fa fa-edit m-right-xs"></i> Editar Sucursal</a>
                        <a class="btn btn-info" href="{{url('sucursales/'.$sucursal->id.'/image')}}">
                            <i class="fa fa-image m-right-xs"></i> Cambiar Imágen</a>
                        @endpermission
                    </div>


                    <br/>
                </div>
            </div>
        </div>

        <div class="col-sm-5 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <h3 class="alignleft">Caja</h3>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <h3 class="alignright">
                        <i style="float: right" class="fa fa-calendar"> {{strftime("%A, %d %B %Y")}}</i>
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table table-striped table-hover table-condensed">
                        <tbody>
                        <tr>
                            <th>Estado</th>
                            <td>
                                @if(\App\Services\SucursalService::isOpen($sucursal->id))
                                    <span class="badge bg-green">Abierta</span>
                                @else <span class="badge bg-red">Cerrada</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Venta (USD)</th>
                            <td>{{isset($caja['sale'])? number_format($caja['sale'],2):'--'}}</td>
                        </tr>
                        <tr>
                            <th>Efectivo (USD)</th>
                            <td>{{isset($caja['cash'])? number_format($caja['cash'],2):'--'}}</td>
                        </tr>
                        <tr>
                            <th>Débito (USD)</th>
                            <td>{{isset($caja['debit'])? number_format($caja['debit'],2):'--'}}</td>
                        </tr>
                        <tr>
                            <th>Deuda (USD)</th>
                            <td>{{isset($caja['debt'])? number_format($caja['debt'],2):'--'}}</td>
                        </tr>
                        <tr>
                            <th>Costo (USD)</th>
                            <td>{{isset($caja['cost'])? number_format($caja['cost'],2):'--'}}</td>
                        </tr>
                        <tr>
                            <th>Abierta en</th>
                            <td>{{$caja['opening']? $caja['opening']->time:'--'}}</td>
                        </tr>
                        <tr>
                            <th>Cerrada en</th>
                            <td>{{$caja['closing']? $caja['closing']->time:'--'}}</td>
                        </tr>
                        </tbody>
                    </table>

                    @permission('admin_caja')

                    @if(\App\Services\SucursalService::isOpen($sucursal->id))
                        <a class="btn btn-danger" data-toggle="modal" data-target="#modal_cerrar">Cerrar Caja</a>
                    @else
                        <a class="btn btn-success" data-toggle="modal" data-target="#modal_abrir">Abrir Caja</a>
                    @endif

                    @endpermission

                </div>
            </div>
        </div>

        @permission('admin_caja')

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <h3>Registro
                        <a href="{{ url("sucursales/$sucursal->id/registry") }}" title="Ver Registro"
                           style="float: right">
                            <div class="btn btn-primary">
                                <i class="fa fa-eye" aria-hidden="true"></i> Ver el registro completo
                            </div>
                        </a>
                    </h3>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table table-hover table-striped" id="datatable">
                        <thead>
                        <tr>
                            <th data-field="stamp" data-sortable="true">Fecha</th>
                            <th data-field="venta" data-sortable="true">Venta (USD)</th>
                            <th data-field="hora" data-sortable="true">Hora</th>
                            <th data-field="estado" data-sortable="true">Estado</th>
                            <th data-field="efectivo" data-sortable="true">Efectivo</th>
                            <th data-field="debito" data-sortable="true">Débito</th>
                            <th data-field="credito" data-sortable="true">Deuda</th>
                            <th data-field="costo" data-sortable="true">Costo</th>
                            <th data-field="user" data-sortable="true">Usuario</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($registros as $registro)
                            <tr>
                                <td rowspan="2">{{$registro['opening']->date}}</td>
                                <td rowspan="2">{{number_format($registro['sale'],2)}}</td>
                                <td>{{$registro['opening']->time}}</td>
                                <td>
                                    @if($registro['opening']->state) Abierta
                                    @else Cerrada
                                    @endif
                                </td>
                                <td>{{$registro['opening']->cash}}</td>
                                <td>{{$registro['opening']->debit}}</td>
                                <td>{{$registro['opening']->debt}}</td>
                                <td>{{$registro['opening']->cost}}</td>
                                <td>{{$registro['opening']->account? $registro['opening']->account->name():'Sistema'}}</td>
                            </tr>

                            @if(isset($registro['closing']))
                                <tr>
                                    <td>{{$registro['closing']->time}}</td>
                                    <td>
                                        @if($registro['closing']->state) Abierta
                                        @else Cerrada
                                        @endif
                                    </td>
                                    <td>{{$registro['closing']->cash}}</td>
                                    <td>{{$registro['closing']->debit}}</td>
                                    <td>{{$registro['closing']->debt}}</td>
                                    <td>{{$registro['closing']->cost}}</td>
                                    <td>{{$registro['closing']->account? $registro['closing']->account->name():'Sistema'}}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>

        @endpermission
    </div>

    <div class="modal fade" id="modal_abrir">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="modal_close" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_label">Abrir Caja</h4>
                </div>
                <form class="form form-inline" method="post" action="{{url('sucursal/caja/abrir')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group hidden">
                            <label for="id">ID</label>
                            <input type="hidden" id="id" name="id" value="{{$sucursal->id}}" required readonly>
                        </div>
                        <p>Digite el efectivo con que abrirá la caja.</p>
                        <div class="form-group">
                            <label for="cash">Efectivo (USD): </label>
                            <input type="number" id="cash" name="cash" class="form-control" step="0.01" min="0"
                                   required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Abrir Caja">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_cerrar">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="modal_close" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_label">Cerrar Caja</h4>
                </div>
                <form method="post" action="{{url('sucursal/caja/cerrar')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group hidden">
                            <label for="id">ID</label>
                            <input type="hidden" id="id" name="id" value="{{$sucursal->id}}" required readonly>
                        </div>
                        <p>Estado actual de la caja:</p>
                        <p><strong>Venta (USD): </strong>{{number_format($caja['sale'],2)}}</p>
                        <p><strong>Efectivo (USD): </strong>{{number_format($caja['cash'],2)}}</p>
                        <p><strong>Débito (USD): </strong>{{number_format($caja['debit'],2)}}</p>
                        <p><strong>Deuda (USD): </strong>{{number_format($caja['debt'],2)}}</p>
                        <p><strong>Costo (USD): </strong>{{number_format($caja['cost'],2)}}</p>
                        <p>¿Está seguro de cerrar la caja?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-danger" value="Cerrar Caja">
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
@endsection