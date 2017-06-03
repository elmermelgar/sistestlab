@extends('layouts.app')

@section('styles')
    <link href="{{url('gentallela/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('css/s2-docs.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .profile_details {
            clear: inherit !important;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/home')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ url('perfiles') }}">Perfiles</a></li>
            <li>Perfil</li>
        </ol>
        <a href="{{ url('perfiles') }}"
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

    <div class="col-xs-6">
        <div class="x_panel">
            <div class="x_title">
                <h3>Perfil {{ $perfil->display_name }}
                    <small>{{ $perfil->name }}</small>
                </h3>

                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <section class="content invoice">
                    <h2><strong>Tipo:</strong>
                        @if($perfil->type)
                            Grupo
                        @else
                            Examen
                        @endif
                    </h2>
                    <p>
                        <strong>Estado: </strong>
                        @if($perfil->enabled)
                            <span style="color:green">Habilitado</span>
                        @else
                            <span style="color:red">Deshabilitado</span>
                        @endif
                    </p>
                    <p>
                        <strong>Descripción:</strong>
                        {{ $perfil->description }}
                    </p>
                    <a href="{{url('perfiles/'.$perfil->id.'/edit')}}"
                       class="btn btn-md btn-warning"><i
                                class="fa fa-edit" aria-hidden="true"></i> Editar Perfil</a>


                </section>


            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <!-- start project-detail sidebar -->

        <div class="x_panel">

            <div class="x_title">
                <h3 class="green">Precios</h3>
                <a href="#" style="float: right; margin-top: -35px" class="btn btn-md btn-primary"
                   title="asignar precios" data-toggle="modal" data-target="#modal_price">
                    <i class="fa fa-edit" aria-hidden="true"></i> Actualizar
                </a>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Sucursal</th>
                        <th>Precio (USD)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($perfil->sucursales as $sucursal)
                        <tr>
                            <td>{{ $sucursal->display_name }}</td>
                            <td>{{ $sucursal->pivot->price }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="green">Exámenes</h3>
                <a href="#" data-toggle="modal" data-target="#modal_add_examen"
                   style="float: right; margin-top: -35px" class="btn btn-md btn-primary">
                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar Examen
                </a>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Precio (USD)</th>
                        <th class="no-print">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0 ?>
                    @foreach($perfil->exams as $examen)
                        <tr>
                            <th scope="row"> <?php $i++ ?> {{ $i }}</th>
                            <td>{{ $examen->name }}</td>
                            <td>{{ $examen->display_name }}</td>
                            <td>{{ $examen->precio }}</td>
                            <td class="no-print">
                                <a href="{{url('examenes/'.$perfil->id.'/'.$examen->id)}}"
                                   class="btn btn-md btn-info">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a data-toggle="modal" data-target="#modal_del_examen" class="btn btn-md btn-danger"
                                   onclick="delExam('{{$examen->id}}','{{$examen->display_name}}')">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @include('perfil.modal_precio')
    @include('perfil.modal_add_examen')
    @include('perfil.modal_del_examen')


@endsection

@section('scripts')
    <script src="{{url('gentallela/vendors/select2/dist/js/select2.js')}}"></script>
    <script>
        function delExam(exam_id, exam_display_name) {
            $("#del_exam_id").val(exam_id);
            $("#exam_display_name").html(exam_display_name);
        }

        $(document).ready(function () {

            function formatRepoExam(repo) {
                if (repo.loading) return repo.text;

                var markup = "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__title'>" + repo.display_name + "</div>";

                if (repo.precio) {
                    markup += "<div class='select2-result-repository__description'>" + repo.precio + "</div>";
                }

                return markup;
            }

            function formatRepoSelectionExam(repo) {
                return repo.display_name || repo.text;
            }

            $("#exam_id").select2({
                placeholder: 'Seleccione un examen',
                ajax: {
//                    url: "https://api.github.com/search/repositories",
                    url: "/facturar/search/exam",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            display_name: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1,
                templateResult: formatRepoExam,
                templateSelection: formatRepoSelectionExam
            });
        });

    </script>

@endsection