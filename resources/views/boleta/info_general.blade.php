<div class="row" >
    <div class="col-sm-12" id="general"
         style="border-radius: 5px; border-style: solid; border-color: silver" >
        <table class="table" style=" margin-top: -1px; margin-bottom: 2px" >
            <tbody>
            <tr style="line-height: 5px;">
                <th style="line-height: 5px;">Paciente:</th>
                <td style="line-height: 5px;"> @if($examen_paciente->paciente_id==null){{ $examen_paciente->paciente_nombre }}
                    @else {{ $examen_paciente->paciente->nombre }} {{ $examen_paciente->paciente->apellido }}@endif &ensp; &ensp; &ensp;</td>
                <th style="line-height: 5px;">Edad:</th>
                <td style="line-height: 5px;">@if($examen_paciente->paciente_id==null) {{ $examen_paciente->paciente_edad }}@endif años </td>
            </tr>
            <tr>
                <th style="line-height: 5px;">Sexo:</th>
                <td style="line-height: 5px;">@if($examen_paciente->paciente_id==null) @if($examen_paciente->paciente_sexo=='M')Masculino @else Femenino @endif @endif</td>
                <th style="line-height: 5px;">N° Boleta:</th>
                <td style="line-height: 5px;"> {{ $examen_paciente->numero_boleta }}</td>
            </tr>
            <tr>
                <th style="line-height: 5px;"> @if($examen_paciente->invoices->factura->cliente->centro_origen==true)Centro de Origen:@else Cliente: @endif</th>
                <td style="line-height: 5px;">{{ $examen_paciente->invoices->factura->cliente->name }}</td>
                <th style="line-height: 5px;">Fecha:</th>
                <td style="line-height: 5px;"> {{ \Carbon\Carbon::parse($examen_paciente->fecha_validado)->format('d/m/Y')}} </td>
            </tr>
            <tr>
                <th style="line-height: 5px;">Prueba Realizada:</th>
                <td style="line-height: 5px;"> {{ $examen->display_name }}</td>
                <th style="line-height: 5px;">Muestra:</th>
                {{--<td>Lic. Yasmin Arevalo de Perez</td>--}}
                <td style="line-height: 5px;">{{ $examen->sample->display_name }}</td>
            </tr>
            </tbody>
        </table>

    </div>
</div>