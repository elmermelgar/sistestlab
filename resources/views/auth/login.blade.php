<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SISTESTLAB | </title>

    <!-- Bootstrap -->
    <link href=" {{asset('gentallela/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('gentallela/build/css/custom.css')}}" rel="stylesheet">
</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <h1>Iniciar Sesión</h1>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input class="form-control" placeholder="Correo Electrónico" id="email" type="email"
                               name="email" value="{{ old('email') }}" required autofocus/>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password"
                               required/>
                    </div>

                    @if ($errors->any())
                        <div class="form-group has-error">
                            <div class="col-md-12">
                                @foreach ($errors->all() as $error)
                                    <span class="help-block">
                                        <strong>{{ $error }}</strong>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="col-sm-12">
                        <input type="submit" class="btn btn-default submit" style="width: 75%" value="Iniciar Sesión"/>
                    </div>

                    <a class="reset_pass" href="{{url('password/reset')}}">¿Olvido su contraseña?</a>
                    <div class="clearfix"></div>

                    <div class="separator">


                        <div class="clearfix"></div>
                        <br/>

                        <div>
                            <h1><i class="fa fa-flask"></i> TESTLAB</h1>
                            <p>©2016 Todos los derechos reservados. SISTESTLAB</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>

    </div>
</div>
</body>
</html>

