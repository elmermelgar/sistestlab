<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SICTUES - @yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{url("lumino/css/bootstrap.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{url("lumino/css/styles.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('asset/css/plugins/font-awesome.min.css') }}"/>
    <link rel="shortcut icon" href="{{url("asset/img/logomi.png")}}">

    @yield('imports')

    <style>
        @media (min-width: 700px) {
            .container {
                width: 100%;
                margin-top: 2%;
            }
        }
        input {
            border-color: #5e5e5e !important;
        }

        input:focus {
            border-color: #00BCD4 !important;
        }
    </style>

    @yield('style')

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
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="{{url("asset/img/logosic.min.png")}}" width="125px" height="35px"
                     style="margin-top: -8px; margin-left: 50px"/>
            </a>
            @if (Auth::guest())

            @else
                <ul class="user-menu">
                    <li class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <svg class="glyph stroked male-user">
                                <use xlink:href="#stroked-male-user"></use>
                            </svg>{{ Auth::user()->name }}<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/perfil')}}">
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

    </div>
</nav>


<div class="container">
    <div id="content">
        @yield('content')
    </div>
</div>

@yield('scripts')

</body>

</html>
