<div class="row factura-encabezado">
    <div class="col-sm-9">
        <h3>TESTLAB</h3>
        <p>SERVICIOS DE ANÁLISIS Y ESTUDIOS DE DIAGNÓSTICO</p>
        <p>YASMIN ELIZABETH ARÉVALO LEMUS</p>
        <p>SUCURSAL {{ strtoupper($sucursal->display_name)}}</p>
        <p>{{ strtoupper($sucursal->direccion)}}</p>
        <p>TEL: (503) {{ $sucursal->telefono}} - CORREO ELECTRÓNICO:{{ $sucursal->email}}</p>
    </div>
    <div class="col-sm-3 factura-fiscal">
        <p>@if(isset($factura)&&$factura->credito_fiscal) CRÉDITO FISCAL @else FACTURA @endif</p>
        <p class="factura-numero">N° {{$factura?$factura->numero:null}}</p>
        <p>NIT: {{ $sucursal->nit}}</p>
        <p>NRC: {{ $sucursal->nrc}}</p>
    </div>
</div>