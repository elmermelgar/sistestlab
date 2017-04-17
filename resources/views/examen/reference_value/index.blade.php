@extends('layouts.app')

@section('styles')

@endsection
@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{url('/examenes')}}">Exámenes</a></li>
            <li>{{$detail? $detail->name_detail:'Nuevo'}}</li>
        </ol>
        <a href="{{ url('examenes/'. $examen->sucursal_id.'/'.$examen->id) }}" style="float: right; margin-top: -50px; margin-right: 20px; font-size: 9px" class="btn btn-dark"><i class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>
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


                <h3>Valores de Referencia</h3>
            <h2>{{ $detail->name_detail }}</h2>
            <a href="{{url('examenes/examen/'.$examen->id.'/create_detail')}}" style="float: right; margin-top: -35px" class="btn btn-sm btn-primary">
                [<i class="fa fa-plus" aria-hidden="true"></i>] Nuevo Valor de Referencia
            </a>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-2"></div>
            <div class="col-md-8">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Valor</th>
                    <th>Unidades</th>
                    <th>Sexo</th>
                    <th>Edad Menor</th>
                    <th>Edad Mayor</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>Otto</td>
                    <td>Otto</td>
                    <td>
                        <a href="{{url('examenes/examen/'.$examen->id.'/'.$detail->id.'/edit_detail')}}" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                        </a>

                        <a href="{{url('examenes/examen/'.$examen->id.'/'.$detail->id.'/delete_detail')}}" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
@section('script-codigo')

@endsection