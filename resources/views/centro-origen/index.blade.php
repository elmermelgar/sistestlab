@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Centros de Origen</li>
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
            <h3>Centros de Origen
                <a href="{{ url('origenes/create') }}" title="Registrar Nuevo Centro de Origen" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> Nuevo Centro de Origen
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
                        <th data-field="name" data-sortable="true">Nombre</th>
                        <th data-field="surname" data-sortable="true">Nombre para mostrar</th>
                        <th data-field="email" data-sortable="true">Email</th>
                        <th data-field="actions" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($origenes as $origen)
                        <tr>
                            <td>{{$origen->id}}</td>
                            <td>{{$origen->name}}</td>
                            <td>{{$origen->display_name}}</td>
                            <td>{{$origen->email}}</td>
                            <td>
                                <a href="{{ url('origenes/'.$origen->id )}}"
                                   class="btn btn-success btn-sm" title="Ver Centro de Origen"><span
                                            class="fa fa-eye fa-fw"></span> Cliente</a>
                                <a href="{{ url('origenes/'. $origen->id.'/edit' )  }}"
                                   class="btn btn-primary btn-sm" title="Editar Centro de Origen"><span
                                            class="fa fa-edit"></span></a>
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