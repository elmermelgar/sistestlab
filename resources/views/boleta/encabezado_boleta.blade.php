<div class="row" style="border-bottom: solid;padding-bottom:10px;border-color: silver;margin-bottom: 10px">
    <div class="col-sm-9"  style="font-size: 8px;">
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
    <div class="col-sm-3"
         style="margin-top: 0;padding:5px 10px;border-radius: 5px;
         border-style: solid; border-color: silver; text-align: center">
         <img class="img-responsive avatar-view" alt="Boleta" title="Testlab" style="max-height: 60px"
        src="{{url('/storage/images/'. 'testlab.png')}}">
    </div>
</div>