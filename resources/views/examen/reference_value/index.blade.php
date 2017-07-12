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
        <a href="{{ url('examenes/'.$examen->id) }}"
           style="float: right; margin-top: -50px; margin-right: 20px; font-size: 9px" class="btn btn-dark"><i
                    class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>
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

            <a href="#" style="float: right; margin-top: -35px" class="btn btn-sm btn-primary" data-toggle="modal"
               data-target=".bs-example-modal-sm">
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
                        <th>*</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($references as $reference)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $reference->value }}</td>
                            <td>{{ $reference->unidades }}</td>
                            <td>{{ $reference->gender  }}</td>
                            <td>{{ $reference->edad_menor }}</td>
                            <td>{{ $reference->edad_mayor }}</td>
                            <td>
                                <a href="{{url('examenes/'.$examen->id.'/'.$detail->id.'/delete_reference/'.$reference->id)}}"
                                   class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
    {{-- Inicio Modal para guardar Valores de Referencia--}}
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Nuevo Valor de Referencia</h4>
                </div>
                <form class="form-horizontal form-label-left" action="{{ url('examenes/storereference') }}"
                      method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" name="exam_detail_id" value="{{ $detail->id }}">
                        {{--Parte 1--}}
                        <fieldset>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Valor (*):
                                    </label>

                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="text" name="value" placeholder="Valor de referencia"
                                               class="form-control col-md-7 col-xs-12" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Unidades (*):
                                    </label>

                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="text" name="unidades" class="form-control col-md-8 col-xs-12"
                                               placeholder="Unidades de Medida" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Sexo:
                                    </label>

                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <select id="gender" name="gender" class="form-control" required>
                                            <option value="Default">Default</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Edad Menor :
                                    </label>

                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="number" name="edad_menor" value="0"
                                               class="form-control col-md-8 col-xs-12"
                                               placeholder="Edad Menor" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12">Edad Mayor :
                                    </label>

                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="number" name="edad_mayor" value="0"
                                               class="form-control col-md-8 col-xs-12"
                                               placeholder="Edad Mayor" required>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar grupo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Fin Modal para guardar Valores de referencia--}}
@endsection

@section('scripts')

@endsection
@section('script-codigo')

@endsection