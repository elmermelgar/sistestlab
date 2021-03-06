@extends('layouts.app')

@section('imports')

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/recolectores')}}">Recolectores</a></li>
            <li>{{$recolector->name()}}</li>
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
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <h3>Recolector {{$recolector->name()}}</h3>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <h4>{{$recolector->name()}}</h4>

                    <ul class="list-unstyled user_data">
                        <li><i class="fa fa-address-card fa-fw user-profile-icon"></i>
                            DUI: <strong>{{$recolector->dui}}</strong>
                        </li>
                        <li><i class="fa fa-address-card fa-fw user-profile-icon"></i>
                            NIT: <strong>{{$recolector->nit}}</strong>
                        </li>
                        <li><i class="fa fa-calendar fa-fw user-profile-icon"></i>
                            Registrado en: <strong>{{$recolector->created_at}}</strong>
                        </li>
                        <li><i class="fa fa-check fa-fw"></i>
                            Estado: <strong>
                                @if($recolector->activo) <span style="color: #0AC3EF">Activo</span>
                                @else <span style="color: #E74C3C">Inactivo</span>
                                @endif
                            </strong>
                        </li>
                    </ul>

                    <a class="btn btn-primary" href="{{url('recolectores/'.$recolector->id.'/edit')}}">
                        <i class="fa fa-edit m-right-xs"></i>Editar Recolector</a>

                    <form method="post" action="
                    @if($recolector->activo) {{url('recolectores/desactivar')}}
                    @else {{url('recolectores/activar')}}
                    @endif">
                        {{csrf_field()}}

                        <div class="form-group hidden">
                            <label for="recolector_id">ID</label>
                            <input type="hidden" id="recolector_id" name="recolector_id" value="{{$recolector->id}}"
                                   required>
                        </div>

                        @if($recolector->activo)
                            <input type="submit" value="Desactivar Recolector" class="btn btn-warning">
                        @else
                            <input type="submit" value="Activar Recolector" class="btn btn-default">
                        @endif

                    </form>
                    <br/>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Recolecciones</h2>
                    <h2 style="float: right"><i class="fa fa-calendar"> {{strftime("%A, %d %B %Y")}}</i></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <h4>Recolecciones realizadas ??ste d??a</h4>

                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">ID Factura</th>
                            <th data-field="monto" data-sortable="true">Monto (USD)</th>
                            <th data-field="accion" data-sortable="false">Acci??n</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $recoleccion_total=0 @endphp
                        @forelse($recolecciones as $recoleccion)
                            <tr>
                                <td>{{$recoleccion->id}}</td>
                                <td>$ {{$recoleccion->total}}</td>
                                <td><a href="{{route('factura.show',$recoleccion->id)}}" class="btn btn-success btn-sm">
                                        <i class="fa fa-eye"></i></a>
                                </td>
                                @php $recoleccion_total+=$recoleccion->total @endphp
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Sin recolecciones este d??a!</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="4">TOTAL (USD): $ {{number_format($recoleccion_total,2)}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <h2>Bonos</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <h4>Bonos aplicados al recolector, este mes:</h4>

                    <table class="table table-striped " id="datatable">
                        <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">#</th>
                            <th data-field="monto" data-sortable="true">Monto (USD)</th>
                            <th data-field="fecha" data-sortable="true">Fecha</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $bono_total=0 @endphp
                        @forelse($bonos_aplicados as $bono)
                            <tr>
                                <td>{{$bono->id}}</td>
                                <td>$ {{$bono->monto}}</td>
                                <td>{{$bono->pivot->date}}</td>
                                @php $bono_total+=$bono->monto @endphp
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Sin bonos aplicados este mes!</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="4">TOTAL (USD): $ {{number_format($bono_total,2)}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success btn-md" data-toggle="modal"
                            data-target="#bonoModal">
                        Aplicar Bono
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- bono Modal -->
    <div class="modal fade" id="bonoModal" tabindex="-1" role="dialog" aria-labelledby="bonoModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="bonoModalLabel">Aplicar Bono</h4>
                </div>
                <form method="post" action="{{url('recolectores/'.$recolector->id.'/bonificar')}}">
                    {{csrf_field()}}

                    <div class="modal-body">

                        <div class="form-group hidden">
                            <label for="id">ID</label>
                            <input id="id" name="id" class="form-control" value="{{$recolector->id}}">
                        </div>
                        <div class="form-group">
                            <label for="bono_id">Bono</label>
                            <select id="bono_id" name="bono_id" class="perms form-control">
                                @foreach($bonos as $bono)
                                    <option value="{{$bono->id}}"> $ {{$bono->monto}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">

                            <input type="checkbox" id="bono_confirm" name="bono_confirm" class="custom-check">
                            <label for="bono_confirm">
                                Marque esta casilla si est?? seguro de aplicar el bono.</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="bono_submit" type="submit" class="btn btn-primary" value="Bonificar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- estado Modal -->
    <div class="modal fade" id="estadoModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="bonoModalLabel">Aplicar Bono</h4>
                </div>
                <form method="post" action="{{url('recolectores/'.$recolector->id.'/bonificar')}}">
                    {{csrf_field()}}

                    <div class="modal-body">

                        <div class="form-group hidden">
                            <label for="id">ID</label>
                            <input id="id" name="id" class="form-control" value="{{$recolector->id}}">
                        </div>
                        <div class="form-group">
                            <label for="bono_id">Bono</label>
                            <select id="bono_id" name="bono_id" class="perms form-control">
                                @foreach($bonos as $bono)
                                    <option value="{{$bono->id}}"> $ {{$bono->monto}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">

                            <input type="checkbox" id="bono_confirm" name="bono_confirm" class="custom-check">
                            <label for="bono_confirm">
                                Marque esta casilla si est?? seguro de aplicar el bono.</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input id="bono_submit" type="submit" class="btn btn-primary" value="Bonificar">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var bono_confirm = $('#bono_confirm');
            var bono_submit = $('#bono_submit');

            function confirmClick() {
                if (bono_confirm[0].checked) {
                    bono_submit.removeAttr('disabled');
                }
                else {
                    bono_submit.attr('disabled', 'disabled');
                }
            }

            confirmClick();
            bono_confirm.change(function () {
                confirmClick()
            });
        });

    </script>
@endsection