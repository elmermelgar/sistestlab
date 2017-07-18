<div class="row">
    <div class="col-sm-9"  style="font-size: 8px;" id="titulo">
        {{--<img class="img-responsive avatar-view" alt="Boleta" title="Testlab"--}}
             {{--style="max-height: 60px"--}}
             {{--src="{{url('/storage/images/'. 'testlab.png')}}">--}}
        <h3 style="font-size: 18px">TESTLAB <br>
            <small>SERVICIOS DE ANÁLISIS Y ESTUDIOS DE DIAGNÓSTICO, </small>

            <small>SUCURSAL {{ strtoupper($sucursal->display_name)}}</small>
        </h3>
        <p>{{ strtoupper($sucursal->direccion)}}</p>
        <p>TEL: (503) {{ $sucursal->telefono}} - CORREO ELECTRÓNICO:{{ $sucursal->email}} </p>
    </div>
    <div class="col-sm-3" id="logo_boleta"
         style="margin-top: 5px;padding:5px 10px;border-radius: 5px;
         border-style: solid; border-color: silver; text-align: center">
         <img class="img-responsive avatar-view" alt="Boleta" title="Testlab" style="max-height: 60px"
        src="{{url('/storage/images/'. 'testlab.png')}}">
    </div>
</div>