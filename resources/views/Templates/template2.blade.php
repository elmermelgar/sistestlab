<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TESTLAB</title>

    <link href="{{url("lumino/css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{url("lumino/css/datepicker3.css")}}" rel="stylesheet">
    <link href="{{url("lumino/css/styles.css")}}" rel="stylesheet">

    <link href="{{url("asset/css/curriculum.css")}}" rel="stylesheet">
    <link rel="stylesheet" id="alertifyCSS" href="{{url("asset/css/plugins/alertify.css")}}"/>
    {{--    <link rel="stylesheet" href="{{url("asset/themes/alertify.default.css")}}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{url("asset/css/plugins/font-awesome.min.css")}}"/>
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
            <a class="navbar-brand" href="{{ url('/inicio')}}"><img src="{{url("asset/img/logosic.min.png")}}"
                                                                    width="125px" height="35px"
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
                            <li><a href="#">
                                    <svg class="glyph stroked male-user">
                                        <use xlink:href="#stroked-male-user"></use>
                                    </svg>
                                    Perfil</a></li>
                            <li><a href="#">
                                    <svg class="glyph stroked flag">
                                        <use xlink:href="#stroked-flag"></use>
                                    </svg>
                                    Ayuda</a></li>
                            <li><a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <svg class="glyph stroked cancel">
                                        <use xlink:href="#stroked-cancel"></use>
                                    </svg>
                                    Cerrar Sesión</a></li>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>

    </div><!-- /.container-fluid -->
</nav>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <form role="search">
        <div class="time">
            <h1>08:00</h1>
            <p>lunes, 25 de julio de 2016</p>
        </div>
    </form>
    <ul class="nav menu" @yield('navid')>


            <li id="inicio" class="active"><a href="{{ url('/inicio')}}">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                    Inicio</a></li>

    </ul>

</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" id="content">
    <div class="row">
        <div class="col-lg-12">
            @yield('content')
        </div>
    </div>
</div>    <!--/.main-->
{{--}}{!! Alert::render('alert') !!}{{--}}

<script src="{{url("lumino/js/jquery-1.11.1.min.js")}}"></script>
<script src="{{url("lumino/js/bootstrap.min.js")}}"></script>
<script src="{{url("asset/js/plugins/moment-with-locales.js")}}"></script>
{{--}}<script src="{{url("lumino/js/chart.min.js")}}"></script>
<script src="{{url("lumino/js/chart-data.js")}}"></script>
<script src="{{url("lumino/js/easypiechart.js")}}"></script>
<script src="{{url("lumino/js/easypiechart-data.js")}}"></script>
<script src="{{url("lumino/js/bootstrap-datepicker.js")}}"></script>--}}
<script type="text/javascript" src="{{url("lumino/js/main.js")}}"></script>
<script type="text/javascript" src="{{url("asset/js/plugins/alertify.js")}}"></script>
<script type="text/javascript">
    alertify.logPosition("bottom right");
    alertify.maxLogItems(3);
</script>
@yield('scripts')

</body>

</html>
