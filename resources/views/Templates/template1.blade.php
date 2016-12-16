<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SICUES</title>

    <link href="{{url("lumino/css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{url("lumino/css/datepicker3.css")}}" rel="stylesheet">
    <link href="{{url("lumino/css/styles.css")}}" rel="stylesheet">

    <link href="{{url("asset/css/curriculum.css")}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url("asset/themes/alertify.core.css")}}"/>
    <link rel="stylesheet" href="{{url("asset/themes/alertify.default.css")}}"/>

    <link rel="shortcut icon" href="{{url("asset/img/logomi.png")}}">
@yield('imports')
@yield('style')

<!--Icons-->
    <script src="{{url("lumino/js/lumino.glyphs.js")}}"></script>

    <!--[if lt IE 9]>
    <script src="lumino/js/html5shiv.js"></script>
    <script src="lumino/js/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#sidebar-collapse">
                <span class="sr-only">Navegacion</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="{{url("asset/img/logosic.min.png")}}" width="125px" height="35px"
                                                  style="margin-top: -8px; margin-left: 50px"/></a>
            @if (Auth::guest())

            @else
                <ul class="user-menu">
                    <li class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <svg class="glyph stroked male-user">
                                <use xlink:href="#stroked-male-user"></use>
                            </svg>{{ Auth::user()->name }}<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/inicio')}}">
                                    <svg class="glyph stroked male-user">
                                        <use xlink:href="#stroked-male-user"></use>
                                    </svg>
                                    Perfil</a></li>
                            <li><a href="{{ url('/ayuda')}}">
                                    <svg class="glyph stroked flag">
                                        <use xlink:href="#stroked-flag"></use>
                                    </svg>
                                    Ayuda</a></li>
                            <li><a href="{{ url('/logout') }}">
                                    <svg class="glyph stroked cancel">
                                        <use xlink:href="#stroked-cancel"></use>
                                    </svg>
                                    Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>

    </div><!-- /.container-fluid -->
</nav>

<div id="sidebar-collapse" class="col-sm-4 col-lg-3 sidebar">
    <ul class="nav menu" @yield('navid')>

        @if(!isset($no_menu))
            <li id="inicio"><a href="#section1">
                    <svg class="glyph stroked male-user">
                        <use xlink:href="#stroked-male-user"></use>
                    </svg>
                    Datos Personales</a></li>

            <li class="parent ">
                <a href="#">
                    <span data-toggle="collapse" href="#sub-item-1"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-clipboard-with-paper"></use></svg>Curriculum</span>
                </a>
                <ul class="children" id="sub-item-1">
                    <li>
                        <a class="" href="#section2">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Formación Académica
                        </a>
                    </li>
                    <li>
                        <a class="" href="#section3">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Experiencia Científica
                        </a>
                    </li>
                    <li>
                        <a class="" href="#section4">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Experiencia Laboral
                        </a>
                    </li>
                    <li>
                        <a class="" href="#section5">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Publicaciones
                        </a>
                    </li>
                    <li>
                        <a class="" href="#section6">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Asociaciones
                        </a>
                    </li>
                    <li>
                        <a class="" href="#section7">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Premios y Distinciones
                        </a>
                    </li>
                    <li>
                        <a class="" href="#section8">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Competencias
                        </a>
                    </li>
                </ul>
            </li>
            <li class="parent ">
                <a href="#">
                    <span data-toggle="collapse" href="#sub-item-2"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-line-graph"></use></svg>Proyectos</span>
                </a>
                <ul class="children" id="sub-item-2">
                    <li>
                        <a class="" href="#section9">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Crear Proyectos
                        </a>
                    </li>
                    <li>
                        <a class="" href="#section10">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Paso 1
                        </a>
                    </li>
                    <li>
                        <a class="" href="#section11">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Paso 2
                        </a>
                    </li>
                    <li>
                        <a class="" href="#section12">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Paso 3
                        </a>
                    </li>

                    <li class="parent ">
                        <a href="#">
                            <span data-toggle="collapse" href="#sub-item-3"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> Paso 4</span>
                        </a>
                        <ul class="collapse" id="sub-item-3">
                            <li class="parent ">
                                <a href="#">
                                    <span data-toggle="collapse" href="#sub-item-4"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-table"></use></svg> Presupuesto</span>
                                </a>
                                <ul class="collapse" id="sub-item-4">
                                    <li>
                                        <a class="" href="#section13">
                                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Contratación de personal
                                        </a>
                                    </li>
                                    <li>
                                        <a class="" href="#section14">
                                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Recursos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="" href="#section15">
                                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Publicaciones
                                        </a>
                                    </li>
                                    <li>
                                        <a class="" href="#section16">
                                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Viaje Local
                                        </a>
                                    </li>
                                    <li>
                                        <a class="" href="#section17">
                                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Viaje al Exterior
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li role="presentation" class="divider"></li>
        @endif
    </ul>

</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" id="content">
    <div class="row">
        <div class="col-lg-12">
            @yield('content')
        </div>
    </div>
</div>    <!--/.main-->

<script src="{{url("lumino/js/jquery-1.11.1.min.js")}}"></script>
<script src="{{url("lumino/js/bootstrap.min.js")}}"></script>
<script src="{{url("asset/js/plugins/moment-with-locales.js")}}"></script>
{{--}}<script src="{{url("lumino/js/chart.min.js")}}"></script>
<script src="{{url("lumino/js/chart-data.js")}}"></script>
<script src="{{url("lumino/js/easypiechart.js")}}"></script>
<script src="{{url("lumino/js/easypiechart-data.js")}}"></script>
<script src="{{url("lumino/js/bootstrap-datepicker.js")}}"></script>--}}
<script type="text/javascript" src="{{url("lumino/js/main.js")}}"></script>
<script type="text/javascript" src="{{url("asset/lib/alertify.js")}}"></script>
@yield('scripts')

</body>

</html>
