@extends('layouts.app')

@section('styles')
    <style>
        .profile_details{
            clear: inherit !important;
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ url('examenes/'. $examen->sucursal_id) }}">Exámenes</a></li>
            <li>Detalle de Examen</li>
        </ol>
        <a href="{{ url('examenes/'. $examen->sucursal_id) }}" style="float: right; margin-top: -50px; margin-right: 20px; font-size: 9px" class="btn btn-dark"><i class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>
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
            <h2>{{ $examen->name }}</h2>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <section class="content invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-11">
                        <h3>
                            <i class="fa fa-flask"></i> {{ $examen->display_name }}.
                            <small class="pull-right">Area: <b>{{ $examen->exam_category->name }}</b></small>
                        </h3>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        {{ $examen->observation }}
                        <address>
                            <strong>Muestra: </strong>
                            {{ $examen->sample->display_name }}
                            <br><strong>Estado: </strong>
                            {{ $examen->estado->display_name }}
                            <br><strong>Sucursal: </strong>
                            {{ $examen->sucursal->display_name }}
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <strong>Costo materiales directos:</strong>
                            ${{ $examen->material_directo }}
                            <br><strong>Costo mano de obra:</strong>
                            ${{ $examen->mano_obra }}
                            <br><strong>Costo indirectos de fabricacion:</strong>
                            ${{ $examen->cif }}
                            <br><strong>Total Costos:</strong>
                            ${{ $examen->material_directo+$examen->mano_obra+$examen->cif }}
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">

                        <address>
                            <strong>Precio:</strong> ${{ $examen->precio }}
                            <br><br>
                            <a href="{{url('examenes/examen/'.$examen->id.'/edit')}}" class="btn btn-sm btn-primary"><i class="fa fa-edit" aria-hidden="true"></i> Editar Examen</a>
                            {{--<a href="#" class="btn btn-sm btn-warning"> Dar de baja</a>--}}
                        </address>
                    </div>
                </div>
                <!-- /.row -->
                <!-- start project-detail sidebar -->
                <div class="col-md-3 ">

                    <section class="panel" style="border-right-color: #f1f1f1">

                        <div class="x_title">
                            <div class="clearfix"></div>
                        </div>
                        <h3 class="green">Grupos</h3>
                        <a href="#" style="float: right; margin-top: -35px" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                        <div class="panel-body">
                        @foreach($grupos as $grupo)
                            <!-- Groupings of Exam -->
                            <div class="accordion" id="accordion{{ $grupo->id }}" role="tablist" aria-multiselectable="true">
                                <div class="panel">

                                    <a class="panel-heading" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion{{ $grupo->id }}" href="#collapseOne{{ $grupo->id }}" aria-expanded="false" aria-controls="collapseOne">
                                        <h4 class="panel-title">{{ $grupo->name }}</h4>
                                        @if(!$grupo->name == '')
                                        <a href="{{url('examenes/examen/'.$examen->id.'/'.$grupo->id.'/delete_group')}}" class="btn btn-sm btn-black" style="float: right; margin-top: -35px; color: #942a25">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                    </a>
                                    <div id="collapseOne{{ $grupo->id }}" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <ul class="to_do">
                                                @foreach($details as $detail)
                                                    @if($grupo->id == $detail->grouping_id)
                                                        <li style="background: #fff;"><span class="label label-success">{{ $detail->name_detail }}</span></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                            <!-- End Groupings of Exam -->
                            <br>

                        </div>
                        <div class="x_title">
                            <div class="clearfix"></div>
                        </div>
                        <h3 class="green">Recursos</h3>
                        <a href="#" style="float: right; margin-top: -35px" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                        <div class="panel-body">
                            <ul class="to_do">
                                <li><span class="label label-default">Reactivo Sprint</span></li>

                            </ul>
                            <br>
                        </div>

                    </section>

                </div>
                <!-- end project-detail sidebar -->

            </section>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="x_title">
                    <div class="clearfix"></div>
                </div>
                <!-- Configuracion de resultados -->
                <h3 class="green"> Resultados de Examen</h3>
                <a href="{{url('examenes/examen/'.$examen->id.'/create_detail')}}" style="float: right; margin-top: -35px" class="btn btn-sm btn-primary">
                    [<i class="fa fa-plus" aria-hidden="true"></i>] Nuevo Resultado
                </a>
                     <div class="panel-body">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Descripcion</th>
                                            <th>*</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php  ?>
                                        @foreach($grupos as $grupo)
                                            @foreach($details as $detail)
                                                @if($grupo->id == $detail->grouping_id)
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>{{ $detail->name_detail }}</td>
                                                        <td>{{ $detail->referenceType->display_name }}</td>
                                                        <td>{{ $detail->description }}</td>
                                                        <td>
                                                            <a href="{{url('examenes/examen/'.$examen->id.'/'.$detail->id.'/edit_detail')}}" class="btn btn-sm btn-warning">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>

                                                            <a href="{{url('examenes/examen/'.$examen->id.'/'.$detail->id.'/delete_detail')}}" class="btn btn-sm btn-danger">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </a>

                                                            <a href="{{url('examenes/examen/'.$examen->id.'/'.$detail->id.'/reference_value')}}" class="btn btn-sm btn-primary" title="Valores de Referencia">
                                                                <i class="fa fa-sliders" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                     </div>
            </div>

        </div>
    </div>
    {{-- Inicio Modal para guardar Grupos--}}
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Nuevo Grupo</h4>
                </div>
                <form class="form-horizontal form-label-left" action="{{ url('examenes/examen/storegrupo') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" value="{{ $examen->id }}">
                        {{--Parte 1--}}
                        <fieldset>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12" >Nombre (*):
                                    </label>

                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="text" name="name" placeholder="Nombre para agrupar"
                                               class="form-control col-md-7 col-xs-12" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-3 col-xs-12" >Descripción (*):
                                    </label>

                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="text" name="display_name" class="form-control col-md-8 col-xs-12" placeholder="Nombre para listar">
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
    {{-- Fin Modal para guardar Grupos--}}

@endsection

@section('scripts')

@endsection