@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentallela/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection

@section('content')


    <div class="page-title">
        <div class="title_left">
            <ol class="breadcrumb">
                <li><a href="{{ url('/inicio')}}">
                        <span class="fa fa-home"></span>
                    </a></li>
                <li>Proveedores</li>
            </ol>
        </div>

        <div class="title_right">
            <div class="form-group pull-right">
                <div class="input-group" style="">
                    <a href="{{route('proveedores.index')}}" style="float: right;" class="btn btn-danger"> <i
                                class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Editando el proveedor "{{$proveedor->nombre}}"</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <form class="form-horizontal form-label-left"
                          action="{{route('proveedores.update',$proveedor->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{--Parte 1--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Nombre
                                    Completo: <span class="required">*</span>
                                </label>

                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="text" name="nombre" required="required" placeholder="Nombre completo"
                                           class="form-control col-md-7 col-xs-12" value="{{$proveedor->nombre}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="last-name">Telefono: <span
                                            class="required">*</span>
                                </label>

                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="text" name="telefono" required="required"
                                           class="form-control col-md-7 col-xs-12" value="{{$proveedor->telefono}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="middle-name"
                                       class="control-label col-md-4 col-sm-3 col-xs-12">Rubro: </label>

                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" type="text"
                                           name="rubro" value="{{$proveedor->rubro}}">
                                </div>
                            </div>

                        </div>
                        {{--Parte 2--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="middle-name" class="control-label col-md-4 col-sm-3 col-xs-12">Ubicacion:
                                    <span class="required">*</span>
                                </label>

                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" type="text"
                                           name="ubicacion" value="{{$proveedor->ubicacion}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12">Email: <span
                                            class="required">*</span>
                                </label>

                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input class="date-picker form-control col-md-7 col-xs-12"
                                           required="required" name="email" type="text" value="{{$proveedor->email}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Otros:
                                </label>

                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="text" name="otros"
                                           class="form-control col-md-7 col-xs-12" value="{{$proveedor->otros}}">
                                </div>
                            </div>
                        </div>
                        {{--<div class="ln_solid"></div>--}}
                        <br><br>
                        <div class="form-group col-md-12" style="margin-top: 40px">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5">
                                <button type="reset" class="btn btn-dark">Restablecer</button>
                                <button type="submit" class="btn btn-success">Actualizar</button>
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
@endsection
@section('script-codigo')
    <script>
        $(document).ready(function () {

            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({
                keys: true
            });

        });
    </script>
@endsection
