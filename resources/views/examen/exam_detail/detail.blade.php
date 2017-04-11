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
            <li>Exámenes</li>
            <li></li>
        </ol>
        <a href="{{ url('sucursales/view') }}" style="float: right; margin-top: -50px; margin-right: 20px; font-size: 9px" class="btn btn-dark"><i class="fa fa-reply-all" aria-hidden="true"></i> Regresar</a>
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
                    <div class="col-xs-10">
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
                            <br><strong>Precio:</strong>
                            ${{ $examen->precio }}
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">

                        <address>
                            <strong></strong>
                            <br>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-edit" aria-hidden="true"></i> Editar Examen</a>
                            <a href="#" class="btn btn-sm btn-warning"> Dar de baja</a>
                        </address>
                    </div>
                </div>
                <!-- /.row -->
                <!-- start project-detail sidebar -->
                <div class="col-md-3 ">

                    <section class="panel">

                        <div class="x_title">
                            <div class="clearfix"></div>
                        </div>
                        <h3 class="green">Grupos</h3>
                        <div class="panel-body">


                            <!-- end of user messages -->
                            <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                                <div class="panel">
                                    <a class="panel-heading" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                                        <h4 class="panel-title">Item #1</h4>
                                    </a>
                                    <div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>First Name</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Mark</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingTwo1" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo">
                                        <h4 class="panel-title">Group Item #2</h4>
                                    </a>
                                    <div id="collapseTwo1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            <p><strong>Collapsible Item 2 data</strong>
                                            </p>
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingThree1" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree1" aria-expanded="false" aria-controls="collapseThree">
                                        <h4 class="panel-title">Group Item #3</h4>
                                    </a>
                                    <div id="collapseThree1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <p><strong>Collapsible Item 3 data</strong>
                                            </p>
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor
                                        </div>
                                    </div>
                                </div>
                            </div><br>

                            <h5>Project files</h5>
                            <ul class="list-unstyled project_files">
                                <li><a href=""><i class="fa fa-file-word-o"></i> Functional-requirements.docx</a>
                                </li>
                                <li><a href=""><i class="fa fa-file-pdf-o"></i> UAT.pdf</a>
                                </li>
                                <li><a href=""><i class="fa fa-mail-forward"></i> Email-from-flatbal.mln</a>
                                </li>
                                <li><a href=""><i class="fa fa-picture-o"></i> Logo.png</a>
                                </li>
                                <li><a href=""><i class="fa fa-file-word-o"></i> Contract-10_12_2014.docx</a>
                                </li>
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

                <h3 class="green"> Detalles de Examen</h3>

                    <!-- end of user messages -->

                     <div class="panel-body">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
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
    </div>



@endsection

@section('scripts')

@endsection