<div class="row" >
    <div class="col-sm-12" id="general"
         style="border-radius: 5px; border-style: solid; border-color: silver" >
        <table class="table" style=" margin-top: -1px; margin-bottom: 2px" >
            <tbody>
            <tr>
                <th>Paciente:</th>
                <td> @if($examen_paciente->paciente_id==null){{ $examen_paciente->paciente_nombre }}
                    @else {{ $examen_paciente->paciente->nombre }} {{ $examen_paciente->paciente->apellido }}@endif &ensp; &ensp; &ensp;</td>
                <th>Edad:</th>
                <td>@if($examen_paciente->paciente_id==null) {{ $examen_paciente->paciente_edad }}@endif años </td>
            </tr>
            <tr>
                <th>Sexo:</th>
                <td>@if($examen_paciente->paciente_id==null) @if($examen_paciente->paciente_genero=='M')Masculino @else Femenino @endif @endif</td>
                <th>N° Boleta:</th>
                <td> {{ $examen_paciente->numero_boleta }}</td>
            </tr>
            <tr>
                <th> @if($examen_paciente->invoices->factura->cliente->centro_origen==true)Centro de Origen:@else Cliente: @endif</th>
                <td>{{ $examen_paciente->invoices->factura->cliente->razon_social }}</td>
                <th>Fecha:</th>
                <td>{{ $examen_paciente->fecha_validado }}</td>
            </tr>
            <tr>
                <th>Prueba Realizada:</th>
                <td> {{ $examen->display_name }}</td>
                <th>Muestra:</th>
                {{--<td>Lic. Yasmin Arevalo de Perez</td>--}}
                <td>{{ $examen->sample->display_name }}</td>
            </tr>
            </tbody>
        </table>

    </div>
</div>