@extends('layouts.app')

@section('imports')
    <link href="{{url('gentallela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ url('/imagenes')}}">Imagenes</a></li>
            <li>Categorías de Imágen</li>
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
            <h3>Categorías de Imágen
                <a href="{{ url('imagenes/categorias/create') }}" title="Registrar Nueva Categoría"
                   style="float: right">
                    <div class="btn btn-primary">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Categoría
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
                        <th data-field="display_name" data-sortable="true">Nombre para Mostrar</th>
                        <th data-field="description" data-sortable="true">Descripción</th>
                        <th data-field="created_at" data-sortable="true">Creado en</th>
                        <th data-field="updated_at" data-sortable="false">Actualizado en</th>
                        <th data-field="actions" data-sortable="false">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($categorias as $categoria)
                        <tr>
                            <td>{{$categoria->getAttribute('id')}}</td>
                            <td>{{$categoria->getAttribute('name')}}</td>
                            <td>{{$categoria->getAttribute('display_name')}}</td>
                            <td>{{$categoria->getAttribute('description')}}</td>
                            <td>{{$categoria->getAttribute('created_at')}}</td>
                            <td>{{$categoria->getAttribute('updated_at')}}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" title="Editar Categoría"
                                   href="{{ url('imagenes/categorias/' . $categoria->getAttribute('id')).'/edit' }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" title="Editar Categoría"
                                   onclick="ModalDel({{$categoria->id .',"'. $categoria->display_name.'"'}})">
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
                <form method="post" action="{{url('imagenes/categorias/delete/')}}">
                    {{csrf_field()}}

                    <div class="modal-body">

                        <div class="form-group hidden">
                            <label for="id">ID</label>
                            <input id="id" name="id" class="form-control">
                        </div>
                        <div class="form-group">
                            <h5><strong>¿Está seguro de eliminar está categoría?</strong></h5>
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