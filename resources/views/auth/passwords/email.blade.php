<!DOCTYPE html>
<html lang="en">
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
    <link href="{{asset('gentallela/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('gentallela/build/css/custom.min.css')}}" rel="stylesheet">
    <style>
        .login_content input[type=submit] {
            float: none !important;
            margin-left: 0 !important;
        }

        .login_content h1:before, .login_content h1:after {
            content: "";
            height: 1px;
            position: absolute;
            top: 10px;
            width: 10% !important;
        }
    </style>

</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form role="form" method="POST" action="{{ url('/password/email') }}">
                    {{ csrf_field() }}
                    <h1>Reestablecer Contraseña</h1>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input class="form-control" placeholder="Correo Electrónico" id="email" type="email"
                               name="email" value="{{ old('email') }}" required autofocus/>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <input type="submit" class="form-control btn btn-primary"
                           value="Enviar vinculo para reestablecer la contraseña"/>

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
