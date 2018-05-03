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
                        <hr>
                        <div class="profile_img">
                            <div id="crop-seal">
                                <!-- Current avatar -->
                                <img class="img-responsive seal-view" alt="Sello" title="Sello" style="max-height: 200px"
                                     src="
                            @if($sucursal->seal)
                                     {{url('/storage/seals/'.$sucursal->seal)}}
                                     @else
                                     {{url('/storage/seals/'. 'seal.png')}}
                                     @endif ">
                            </div>
                        </div>
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
                            <i class="fa fa-image m-right-xs"></i> Cambiar Logo</a>
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
                    <h4 class="alignright" style="padding-top:5px">
                        <i style="float: right" class="fa fa-calendar"> {{strftime("%A, %d %B %Y")}}</i>
                    </h4>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table table-striped table-hover table-condensed">
                        <tbody>
                        <tr>
                            <th>Estado</th>
                            <td>
                                @if($caja? $caja->state:false)
                                    <span class="badge bg-green">Abierta</span>
                                @else <span class="badge bg-red">Cerrada</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Efectivo (USD)</th>
                            <td>{{$caja? $caja->cash:'--'}}</td>
                        </tr>
                        <tr>
                            <th>Débito (USD)</th>
                            <td>{{$caja? $caja->debit:'--'}}</td>
                        </tr>
                        <tr>
                            <th>Facturación (USD)</th>
                            <td>{{$caja? $caja->billing:'--'}}</td>
                        </tr>
                        <tr>
                            <th>Abierta el</th>
                            <td>{{$caja? $caja->open_date.'  '.$caja->open_time:'--'}}</td>
                        </tr>
                        <tr>
                            <th>Cerrada el</th>
                            <td>{{$caja? $caja->close_date.'  '.$caja->close_time:'--'}}</td>
                        </tr>
                        </tbody>
                    </table>

                    @permission('admin_caja')

                    @if($caja? $caja->state:false)
                        <a class="btn btn-danger" data-toggle="modal" data-target="#modal_cerrar">
                            <i class="fa fa-times fa-fw"></i>Cerrar Caja</a>
                    @else
                        <a class="btn btn-success" data-toggle="modal" data-target="#modal_abrir">
                            <i class="fa fa-check fa-fw"></i>Abrir Caja</a>
                    @endif

                    @endpermission

                </div>
            </div>
        </div>

        @permission('admin_caja')

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <h3>Registro <small>últimos tres días</small>
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

                    @include('sucursal.registry_detail')

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
                <form class="form form-inline" method="post" action="{{route('sucursal.open_box')}}">
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
                <form method="post" action="{{route('sucursal.close_box')}}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group hidden">
                            <label for="id">ID</label>
                            <input type="hidden" id="id" name="id" value="{{$sucursal->id}}" required readonly>
                        </div>
                        <p>Estado actual de la caja:</p>
                        <p><strong>Facturación (USD): </strong>{{$caja? $caja->billing:null}}</p>
                        <p><strong>Pagos (USD): </strong>{{$caja? $caja->payment:null}}</p>
                        <p><strong>Cobros (USD): </strong>{{$caja? $caja->charge:null}}</p>
                        <p><strong>Efectivo (USD): </strong>{{$caja? $caja->cash:null}}</p>
                        <p><strong>Débito (USD): </strong>{{$caja? $caja->debit:null}}</p>
                        <p><strong>Deuda (USD): </strong>{{$caja? $caja->debt:null}}</p>
                        <p><strong>Costo (USD): </strong>{{$caja? $caja->cost:null}}</p>
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