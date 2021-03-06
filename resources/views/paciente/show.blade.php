@extends('layouts.app')

@section('imports')

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            @if(Auth::user()->can('admin_pacientes'))
                <li><a href="{{url('/pacientes')}}">Pacientes</a></li>
            @endif
            <li>{{$paciente->name}}</li>
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

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h3>Paciente {{$paciente->name}}</h3>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h4>{{$paciente->name}}</h4>

                <ul class="list-unstyled user_data">

                    <li><i class="fa fa-address-card fa-fw user-profile-icon"></i>
                        Documento de identidad: <strong>{{$paciente->identity_document}}</strong>
                    </li>
                    <li><i class="fa fa-genderless fa-fw user-profile-icon"></i>
                        Sexo: <strong>{{$paciente->sex}}</strong>
                    </li>
                    <li><i class="fa fa-calendar fa-fw user-profile-icon"></i>
                        Nacimiento: <strong>{{$paciente->birth_date}}
                            ({{\Carbon\Carbon::parse($paciente->birth_date)->age}} años)</strong>
                    </li>
                    <li><i class="fa fa-phone fa-fw user-profile-icon"></i>
                        Telefono: <strong>{{$paciente->phone_number}}</strong>
                    </li>
                    <li><i class="fa fa-bank fa-fw user-profile-icon"></i>
                        Dirección: <strong>{{$paciente->address}}</strong>
                    </li>
                    <li><i class="fa fa-briefcase fa-fw user-profile-icon"></i>
                        Profesión: <strong>{{$paciente->profession?:'--'}}</strong>
                    </li>
                    <li><i class="fa fa-comment fa-fw user-profile-icon"></i>
                        Observación: <strong>{{$paciente->comment}}</strong>
                    </li>
                    <li><i class="fa fa-calendar fa-fw user-profile-icon"></i>
                        Registrado en: <strong>{{$paciente->created_at}}</strong>
                    </li>
                </ul>

                <a class="btn btn-primary" href="
                @if(Auth::user()->can('admin_pacientes'))
                {{url('pacientes/'.$paciente->id.'/edit')}}
                @else
                {{url('paciente/editar/')}}
                @endif "><i class="fa fa-edit fa-fw m-right-xs"></i>Editar Paciente</a>
                @if($paciente->account->customer)
                    <a class="btn btn-default" href="{{route('customer.show',$paciente->account->customer->id)}}">
                        <i class="fa fa-eye fa-fw"></i>Ver perfil de cliente</a>
                @endif
                <br/>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h2>Clientes Asociados</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if($paciente->account->customer)
                    <h4><strong>Este paciente está registrado como cliente.</strong>
                        <a href="{{route('customer.show',$paciente->account->customer->id)}}">Ver perfil de cliente.</a>
                    </h4><hr>
                @endif
                <h4>Este paciente se ha asociado a los siguientes clientes:</h4>

                <table class="table table-striped " id="datatable">
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">ID</th>
                        <th data-field="name" data-sortable="true">Razón Social</th>
                        <th data-field="actions" data-sortable="true">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($paciente->customers as $cliente)
                        <tr>
                            <td>{{$cliente->id}}</td>
                            <td>{{$cliente->name}}</td>
                            <td>
                                <a class="btn btn-info btn-xs" title="Ver Cliente"
                                   href="{{ url('clientes/' . $cliente->id) }}">
                                    <i class="fa fa-eye"></i> Ver Cliente
                                </a>
                            </td>
                        </tr>
                    @empty
                        <td colspan="4">Sin clientes asociados!</td>
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
@endsection