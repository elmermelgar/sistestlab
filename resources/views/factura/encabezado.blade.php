<div class="row" style="border-bottom: solid;padding-bottom:10px;border-color: silver;margin-bottom: 10px">
    <div class="col-sm-9">
        <h3>TESTLAB <br>
            <small>SERVICIOS DE ANÁLISIS Y ESTUDIOS DE DIAGNÓSTICO</small>
            <br>
            <small>SUCURSAL {{ strtoupper($sucursal->display_name)}}</small>
        </h3>
        <p>{{ strtoupper($sucursal->direccion)}}</p>
        <p>TEL: (503) {{ $sucursal->telefono}} - CORREO ELECTRÓNICO:{{ $sucursal->email}} </p>
    </div>
    <div class="col-sm-3"
         style="margin-top: 2em;padding:5px 10px;border-radius: 5px;
         border-style: solid; border-color: silver; text-align: center">
        <p>FACTURA</p>
        <p style="color: red; font-size: 20px">N° {{$factura?$factura->numero:null}}</p>
        <p style="margin:0">NIT: {{ $sucursal->nit}}</p>
        <p style="margin:0">NRC: {{ $sucursal->nrc}}</p>
    </div>
</div>