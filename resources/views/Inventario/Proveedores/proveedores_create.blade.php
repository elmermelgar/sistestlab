@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('gentallela/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    @endsection

@section('content')

    <div class="">
            <div class="page-title">
                <div class="title_left">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/inicio')}}">
                                <i class="fa fa-home"></i>
                            </a></li>
                        <li>Proveedores</li>
                    </ol>
                </div>

                <div class="title_right">
                    <div class="form-group pull-right">
                        <div class="input-group" style="">
                            <a href="{{route('proveedores.index')}}" style="float: right;" class="btn btn-danger"><i class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Creando un nuevo proveedor</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left" action="{{route('proveedores.store')}}" method="POST">
                                {{ csrf_field() }}
                                {{--Parte 1--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Nombre Completo: <span class="required">*</span>
                                        </label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input type="text" name="nombre" required="required" placeholder="Nombre completo"
                                                   class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Telefono: <span class="required">*</span>
                                        </label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input type="text" name="telefono"  required="required" title="Debe introducir 8 numeros" placeholder="00000000" pattern="[0-9]{8}"
                                                   class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="middle-name" class="control-label col-md-4 col-sm-3 col-xs-12">Rubro: </label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" type="text" placeholder="Rubro"
                                                   name="rubro">
                                        </div>
                                    </div>

                                </div>
                                {{--Parte 2--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="middle-name" class="control-label col-md-4 col-sm-3 col-xs-12">Ubicacion: <span class="required">*</span>
                                        </label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" type="text" placeholder="Dirección"
                                                   name="ubicacion" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Email: <span
                                                    class="required">*</span>
                                        </label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input class="date-picker form-control col-md-7 col-xs-12" placeholder="ejemplo@gmail.com"
                                                   required="required" name="email" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Otros:
                                        </label>

                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input type="text" name="otros" placeholder="Observación o nota"
                                                   class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="ln_solid"></div>--}}
                                <br><br>
                                <div class="form-group col-md-12" style="margin-top: 40px">
                                    <div class="col-md-12 col-sm-12 col-xs-12 " style="text-align: center">
                                        <button type="reset" class="btn btn-dark">Limpiar</button>
                                        <button type="submit" class="btn btn-success">Guardar</button>
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
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    @endsection
@section('script-codigo')
<script>
    $(document).ready(function() {

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
            keys: true
        });

    });
</script>
@endsection
