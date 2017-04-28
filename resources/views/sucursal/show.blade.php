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
                <h3>Caja
                    <i style="float: right" class="fa fa-calendar"> {{strftime("%A, %d %B %Y")}}</i>
                </h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Estado</th>
                        <td>
                            @if(\App\Services\SucursalService::isOpen($sucursal->id)) <span class="badge bg-green">Abierta</span>
                            @else <span class="badge bg-red">Cerrada</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Efectivo (USD)</th>
                        <td>{{number_format($caja->efectivo,2)}}</td>
                    </tr>
                    <tr>
                        <th>Abierta en</th>
                        <td>{{($caja->open_time)? :'--'}}</td>
                    </tr>
                    <tr>
                        <th>Cerrada en</th>
                        <td>{{($caja->close_time)?:'--'}}</td>
                    </tr>
                    </tbody>
                </table>

                @permission('admin_caja')

                <form method="post" action="
                @if(\App\Services\SucursalService::isOpen($sucursal->id)) {{url('sucursal/caja/cerrar')}}
                @else {{url('sucursal/caja/abrir')}}
                @endif">
                    {{csrf_field()}}

                    <div class="form-group hidden">
                        <label for="id">ID</label>
                        <input id="id" name="id" value="{{$sucursal->id}}">
                    </div>

                    @if(\App\Services\SucursalService::isOpen($sucursal->id))
                        <input type="submit" value="Cerrar Caja" class="btn btn-danger">
                    @else
                        <input type="submit" value="Abrir Caja" class="btn btn-success">
                    @endif

                </form>

                @endpermission

            </div>
        </div>
    </div>

    @permission('admin_caja')

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h2>Registro</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-striped " id="datatable">
                    <thead>
                    <tr>
                        <th data-field="stamp" data-sortable="true">Fecha y Hora</th>
                        <th data-field="estado" data-sortable="true">Estado</th>
                        <th data-field="efectivo" data-sortable="true">Efectivo</th>
                        <th data-field="debito" data-sortable="true">Debito</th>
                        <th data-field="credito" data-sortable="true">Credito</th>
                        <th data-field="user" data-sortable="true">Usuario</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($registros as $registro)
                        <tr>
                            <td>{{$registro->stamp}}</td>
                            <td>
                                @if($registro->estado) Abierta
                                @else Cerrada
                                @endif
                            </td>
                            <td>{{$registro->efectivo}}</td>
                            <td>{{$registro->debito}}</td>
                            <td>{{$registro->credito}}</td>
                            <td>{{$registro->user? $registro->user->getFullName():'Sistema'}}</td>
                        </tr>
                    @empty
                        <td colspan="6">Sin registro!</td>
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>

    @endpermission

@endsection

@section('scripts')
@endsection