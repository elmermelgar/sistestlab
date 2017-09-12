@extends('layouts.app')

@section('imports')
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Pacientes</li>
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
            <h3 class="alignleft">Pacientes</h3>
            <div class="alignright">
                <a href="{{ url('pacientes/create') }}" title="Registrar Nuevo Paciente" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Paciente
                    </div>
                </a>
            </div>
            <div class="alignright">
                <div class="form-group pull-right top_search" style="margin-right: 5%">
                    <form class="form-group" action="{{ url('pacientes') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="nombre" placeholder="Buscar por nombre...">
                            <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">Buscar</button>
                    </span>
                        </div>
                    </form>
                </div>
            </div>


            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <table class="table table-hover" id="datatable">
                <thead>
                <tr>
                    <th data-field="id" data-sortable="true">ID</th>
                    <th data-field="identity_document" data-sortable="true">DUI</th>
                    <th data-field="name" data-sortable="true">Nombre</th>
                    <th data-field="surname" data-sortable="true">Apellido</th>
                    <th data-field="telefono" data-sortable="true">Teléfono</th>
                    <th data-field="actions" data-sortable="false">Acciones</th>
                </tr>
                </thead>

                <tbody>
                @foreach($pacientes as $paciente)
                    <tr>
                        <td>{{$paciente->id}}</td>
                        <td>{{$paciente->identity_document}}</td>
                        <td>{{$paciente->first_name}}</td>
                        <td>{{$paciente->last_name}}</td>
                        <td>{{$paciente->phone_number}}</td>
                        <td>
                            <a href="{{ url('pacientes/'.$paciente->id )}}"
                               class="btn btn-success btn-sm" title="Ver Paciente"><i
                                        class="fa fa-eye"></i></a>
                            <a href="{{ url('pacientes/'. $paciente->id.'/edit' )  }}"
                               class="btn btn-primary btn-sm" title="Editar Paciente"><i
                                        class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            <div class="col-md-12" style="text-align: center">
                {{ $pacientes->appends(Request::only(['nombre']))->render() }}
            </div>
        </div>
    </div>

@endsection

@section('scripts')
@endsection