@extends('layouts.app')

@section('styles')
@endsection

@section('content')

    <div class="page-title">
        <div class="title_left">
            <ol class="breadcrumb">
                <li><a href="{{ url('home')}}"><i class="fa fa-home"></i></a></li>
                <li>Proveedores</li>
            </ol>
        </div>

        <div class="title_right">
            <div class="form-group pull-right">
                <div class="input-group" style="">
                    <a href="{{route('proveedores.index')}}" style="float: right;" class="btn btn-danger"><i
                                class="fa fa-reply-all"></i> Regresar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>@if($proveedor) Editando el proveedor "{{$proveedor->nombre}}"
                        @else Creando un nuevo proveedor
                        @endif
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <form class="form-horizontal form-label-left" method="POST"
                          action="@if($proveedor) {{route('proveedores.update',$proveedor->id)}}
                          @else {{route('proveedores.store')}}
                          @endif ">
                        {{ csrf_field() }}
                        {{--Parte 1--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Nombre
                                    Completo: <span class="required">*</span>
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input name="nombre" placeholder="Nombre completo" required
                                           class="form-control col-md-7 col-xs-12" maxlength="100"
                                           value="{{$proveedor? $proveedor->nombre:old('nombre')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="telefono" class="control-label col-md-4 col-sm-3 col-xs-12">Telefono:
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input id="telefono" name="telefono" class="form-control col-md-7 col-xs-12"
                                           data-inputmask="'mask': '9999-9999'"
                                           value="{{$proveedor? $proveedor->telefono:old('telefono')}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rubro" class="control-label col-md-4 col-sm-3 col-xs-12">Rubro: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input name="rubro" class="form-control col-md-7 col-xs-12" placeholder="Rubro"
                                           maxlength="255" value="{{$proveedor? $proveedor->rubro:old('rubro')}}">
                                </div>
                            </div>
                        </div>
                        {{--Parte 2--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ubicacion" class="control-label col-md-4 col-sm-3 col-xs-12">Ubicación:
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input id="ubicacion" name="ubicacion" class="form-control col-md-7 col-xs-12"
                                           maxlength="255"
                                           value="{{$proveedor? $proveedor->ubicacion:old('ubicacion')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12">Email:
                                    <span class="required">*</span>
                                </label>

                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input name="email" type="email" class="date-picker form-control col-md-7 col-xs-12"
                                           placeholder="ejemplo@gmail.com" maxlength="255" required
                                           value="{{$proveedor? $proveedor->email:old('email')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Otros:
                                </label>

                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input name="otros" class="form-control col-md-7 col-xs-12"
                                           placeholder="Observación o nota" maxlength="255"
                                           value="{{$proveedor? $proveedor->otros:old('otros')}}">
                                </div>
                            </div>
                        </div>
                        {{--<div class="ln_solid"></div>--}}
                        <br><br>
                        <div class="form-group col-md-12" style="margin-top: 40px">
                            <div class="col-md-12" style="text-align: center">
                                <button type="reset" class="btn btn-dark">
                                    @if($proveedor) Restablecer @else Limpiar @endif</button>
                                <button class="btn btn-success">
                                    @if($proveedor) Actualizar @else Guardar @endif</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            Inputmask().mask(document.querySelectorAll("input"));
        });
    </script>
@endsection
