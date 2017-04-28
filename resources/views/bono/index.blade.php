@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li>Bonos</li>
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
            <h3>Bonos
                <a href="{{ url('bonos/create') }}" title="Registrar Nuevo Paciente" style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> Nuevo Bono
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
                        <th data-field="monto" data-sortable="true">Monto (USD)</th>
                        <th data-field="descripcion" data-sortable="true">Descripción</th>
                        <th data-field="created_at" data-sortable="true">Creado</th>
                        <th data-field="updated_at" data-sortable="true">Actualizado</th>
                        <th data-field="actions" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($bonos as $bono)
                        <tr>
                            <td>{{$bono->id}}</td>
                            <td>{{$bono->monto}}</td>
                            <td>{{$bono->descripcion}}</td>
                            <td>{{$bono->created_at}}</td>
                            <td>{{$bono->updated_at}}</td>
                            <td>
                                <a href="{{ url('bonos/'. $bono->id.'/edit' )  }}"
                                   class="btn btn-primary btn-sm" title="Editar Bono"><span
                                            class="fa fa-edit"></span></a>
                                <a class="btn btn-danger btn-sm" title="Eliminar Bono"
                                   onclick="ModalDel({{$bono->id .',"'. $bono->descripcion.'"'}})">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         style="z-index: 9999 !important;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteModalLabel">Eliminar Categoría de Imágen</h4>
                </div>
                <form method="post" action="{{url('bonos/delete/')}}">
                    {{csrf_field()}}

                    <div class="modal-body">

                        <div class="form-group hidden">
                            <label for="id">ID</label>
                            <input id="id" name="id" class="form-control">
                        </div>
                        <div class="form-group">
                            <h5><strong>¿Está seguro de eliminar este bono?</strong></h5>
                            <p id="deleteName"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-danger" value="Eliminar">
                    </div>
                </form>
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

        var modalDel = $('#deleteModal');
        var nameDel = document.getElementById('deleteName');
        var idInput = document.getElementById('id');

        function ModalDel(id, name) {
            idInput.value = id;
            nameDel.innerHTML=name;
            modalDel.modal('show');
        }
    </script>
@endsection