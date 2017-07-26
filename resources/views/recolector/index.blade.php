@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Recolectores</li>
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

    <div class="x_panel">

        <div class="x_title">
            <h3>Recolectores
                <a href="{{ url('recolectores/create') }}" title="Registrar Nuevo Recolector" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> Nuevo Recolector
                    </div>
                </a>
            </h3>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table">
                <table class="table table-striped" id="datatable">
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">Id</th>
                        <th data-field="dui" data-sortable="true">DUI</th>
                        <th data-field="name" data-sortable="true">Nombre</th>
                        <th data-field="surname" data-sortable="true">Apellido</th>
                        <th data-field="actions" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($recolectores as $recolector)
                        <tr>
                            <td>{{$recolector->id}}</td>
                            <td>{{$recolector->dui}}</td>
                            <td>{{$recolector->nombre}}</td>
                            <td>{{$recolector->apellido}}</td>
                            <td>
                                <a href="{{ url('recolectores/'.$recolector->id )}}"
                                   class="btn btn-success btn-sm" title="Ver Recolector"><i
                                            class="fa fa-eye"></i></a>
                                <a href="{{ url('recolectores/'. $recolector->id.'/edit' )  }}"
                                   class="btn btn-primary btn-sm" title="Editar Recolector"><i
                                            class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('gentallela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#datatable').dataTable();
        });
    </script>
@endsection