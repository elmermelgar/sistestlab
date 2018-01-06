<div class="title">
    <div class="col-xs-3">
        <img class="img-responsive" alt="Testlab" title="Testlab"
             src="{{$image}}">
    </div>
    <div class="col-xs-9">
        <p>SERVICIOS DE ANÁLISIS Y ESTUDIOS DE DIAGNÓSTICO</p>
        <p>YASMIN ELIZABETH ARÉVALO LEMUS</p>
        <p>SUCURSAL {{ strtoupper($sucursal->display_name)}}</p>
        <p>{{ strtoupper($sucursal->direccion)}}</p>
        <p>TEL: (503) {{ $sucursal->telefono}} - CORREO ELECTRÓNICO:{{ $sucursal->email}}</p>
    </div>
    <div class="clearfix"></div>
</div>