<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TestLab') }}</title>

    <!-- Styles -->

    <!-- Bootstrap -->
    <link href="{{url('gentallela/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{url('gentallela/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{{url('gentallela/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css')}}"
          rel="stylesheet"/>
    <!-- PNotify -->
    <link href="{{url('pnotify/pnotify.custom.min.css')}}" rel="stylesheet">
    @yield('styles')
    <!-- Custom Theme Style -->
    <link href="{{url('gentallela/build/css/custom.css')}}" rel="stylesheet">

    @yield('imports')


</head>
<body class="nav-md">

<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{url('/')}}" class="site_title">
                        <img src="
                        {{url('/storage/images/'.\App\Imagen::getDefaultImage()->file_name)}}"
                             alt="TestLab"
                             class=" img-responsive">

                        {{--<i class="fa fa-flask"></i>--}}
                        {{--<span>{{ config('app.name', 'TestLab') }}</span>--}}

                    </a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="
                        @if(Auth::user()->photo)
                        {{url('/storage/photos/'.Auth::user()->photo)}}
                        @else
                        {{url('/storage/photos/'. 'user.png')}}
                        @endif " alt="avatar" class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Bienvenido,</span>
                        <h2>{{Auth::user()->name.' '.Auth::user()->surname}}</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            <li><a href="{{url('/home')}}"><i class="fa fa-home"></i> Inicio</a></li>

                            @include('menu.sucursal')

                            @if(Auth::user()->hasRole('admin'))
                                @include('menu.admin')
                            @endif

                        </ul>
                    </div>
                    <div class="menu_section">
                        <h3>Live On</h3>
                        <ul class="nav side-menu">
                            <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="page_403.html">403 Error</a></li>
                                    <li><a href="page_404.html">404 Error</a></li>
                                    <li><a href="page_500.html">500 Error</a></li>
                                    <li><a href="plain_page.html">Plain Page</a></li>
                                    <li><a href="login.html">Login Page</a></li>
                                    <li><a href="pricing_tables.html">Pricing Tables</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <img src="
                                @if(Auth::user()->photo)
                                {{url('/storage/photos/'.Auth::user()->photo)}}
                                @else
                                {{url('/storage/photos/'. 'user.png')}}
                                @endif "
                                     alt=""> {{Auth::user()->name.' '.Auth::user()->surname}}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="{{url('usuario/perfil')}}"> Perfil</a></li>
                                <li><a href="{{url('ayuda')}}">Ayuda</a></li>
                                <li>
                                    <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out pull-right"></i> Salir
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>

                        <li role="presentation" class="dropdown">
                            <a href="" class="dropdown-toggle info-number" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green">2</span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                                        <span class="image"><img src="{{url('gentallela/images/user.png')}}"
                                                                 alt="Profile Image"/></span>
                                        <span>
                                            <span>{{Auth::user()->getFullName()}}</span>
                                            <span class="time">hace 3 min</span>
                                        </span>
                                        <span class="message">
                                            Ahora las sucursales poseen logos.
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a>
                                            <strong>Mirar todas las alertas</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{url('sucursal')}}">
                                <span>Sucursal {{Auth::user()->sucursal->display_name}}</span>
                                <span style="margin: 5px 10px" class="badge bg-red pull-right">Cerrada</span>
                            </a>
                        </li>


                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                @yield('content')
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Plantilla por <a href="http://colorlib.com" target="_blank">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- Scripts -->
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>

<!-- jQuery -->
<script src="{{url('gentallela/vendors/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{url('gentallela/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('gentallela/vendors/fastclick/lib/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{url('gentallela/vendors/nprogress/nprogress.js')}}"></script>
<!-- jQuery custom content scroller -->
<script src="{{url('gentallela/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- PNotify -->
<script src="{{url('pnotify/pnotify.custom.min.js')}}"></script>
@include('laravelPnotify::notify')
@yield('scripts')
<!-- Custom Theme Scripts -->
<script src="{{url('gentallela/build/js/custom.js')}}"></script>

@yield('script-codigo')

</body>
</html>
