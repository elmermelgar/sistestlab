<div class="row">
    {{--<div class="col-sm-9"  style="font-size: 8px; margin-top: -15px" id="titulo">--}}
        {{--<img class="img-responsive avatar-view" alt="Boleta" title="Testlab"--}}
             {{--style="max-height: 60px"--}}
             {{--src="{{url('/storage/images/'. 'testlab.png')}}">--}}
        {{--<h3 style="font-size: 14px" id="test">TESTLAB <br>--}}
            {{--<small id="serv">SERVICIOS DE ANÁLISIS Y ESTUDIOS DE DIAGNÓSTICO, </small>--}}

            {{--<small id="serv">SUCURSAL {{ strtoupper($sucursal->display_name)}}</small>--}}
        {{--</h3>--}}
        {{--<p>{{ strtoupper($sucursal->direccion)}}</p>--}}
        {{--<p>TEL: (503) {{ $sucursal->telefono}} - CORREO ELECTRÓNICO:{{ $sucursal->email}} </p>--}}
    {{--</div>--}}
    <div class="col-sm-12" id="logo_boleta"
         style="margin-top: -30px; text-align: center; ">

        <div style="margin-left: 30%">
            <img class="img-responsive avatar-view" alt="Boleta" title="Testlab" style="max-height: 80px; margin: auto"
                                   src="{{public_path().'/storage/images/'.Auth::user()->account->sucursal->imagen->file_name}}">
        </div>

        <br><br><br>

    </div>
    <div class="col-sm-12" style="text-align: center"><h3 style="font-size: 14px" id="test">INFORME DE RESULTADOS DE LABORATORIO
        </h3></div>
</div>