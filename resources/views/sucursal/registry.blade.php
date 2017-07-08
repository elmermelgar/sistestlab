@extends('layouts.app')

@section('imports')
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/sucursales')}}">Sucursales</a></li>
            <li><a href="{{url("sucursales/$sucursal->id")}}">{{$sucursal->display_name}}</a></li>
            <li>Registro</li>
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

    @permission('admin_caja')

    <div class="x_panel">
        <div class="x_title">
            <h3>Sucursal {{$sucursal->display_name}} </h3>
            <h2>Registro de caja</h2>
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
                    <th data-field="user" data-sortable="true">Usuario</th>
                </tr>
                </thead>

                <tbody>
                @foreach($registros as $registro)
                    <tr>
                        <td rowspan="2">{{$registro['opening']->date}}</td>
                        <td rowspan="2">{{number_format(0,2)}}</td>
                        <td>{{$registro['opening']->time}}</td>
                        <td>
                            @if($registro['opening']->state) Abierta
                            @else Cerrada
                            @endif
                        </td>
                        <td>{{$registro['opening']->cash}}</td>
                        <td>{{$registro['opening']->debit}}</td>
                        <td>{{$registro['opening']->debt}}</td>
                        <td>{{$registro['opening']->user? $registro['opening']->user->getFullName():'Sistema'}}</td>
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
                            <td>{{$registro['closing']->user? $registro['closing']->user->getFullName():'Sistema'}}</td>
                        </tr>
                    @else
                        <tr>
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
            <div class="col-md-12" style="text-align: center">
                {{ $registros->links() }}
            </div>

        </div>
    </div>

    @endpermission

@endsection

@section('scripts')
@endsection