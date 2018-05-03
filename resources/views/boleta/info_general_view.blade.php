<div class="row" >
    <div class="col-sm-12" id="general"
         style="border-radius: 5px; border-style: solid; border-color: silver" >
        <table class="table" style=" margin-top: -1px; margin-bottom: 2px" >
            <tbody>
            <tr style="margin-top: 20px; line-height: 5px">
                <th style="line-height: 5px; ">Paciente:</th>
                <td  style="width: 300px; line-height: 5px"> @if($examen_paciente->paciente_id==null){{ $examen_paciente->paciente_nombre }}
                    @else {{ $examen_paciente->paciente->nombre }} {{ $examen_paciente->paciente->apellido }}@endif </td>
                <th  style="line-height: 5px">Solicitud N°:</th>
                <td style="color: red; line-height: 5px" ><b> {{ $examen_paciente->numero_boleta }}</b></td>

            </tr>
            <tr>
                <th  style="line-height: 5px">Edad:</th>
                <td  style="line-height: 5px">@if($examen_paciente->paciente_id==null) @if($examen_paciente->paciente_edad){{ $examen_paciente->paciente_edad }} años @else No se brindó @endif @endif  </td>
                <th  style="line-height: 5px">Fecha:</th>
                <td  style="line-height: 5px"> @php setlocale(LC_TIME, 'es_SV.UTF-8', 'es') @endphp {{ strftime("%d de %B de %Y", \Carbon\Carbon::parse($examen_paciente->fecha_validado)->timestamp)}} </td>
            </tr>
            <tr>

                <th  style="line-height: 5px">Sexo:</th>
                <td  style="line-height: 5px">@if($examen_paciente->paciente_id==null) @if($examen_paciente->paciente_sexo=='M')Masculino @else Femenino @endif @endif</td>
                <th  style="line-height: 5px">Validado por:</th>
                {{--<td>Lic. Yasmin Arevalo de Perez</td>--}}
                <td  style="line-height: 5px">@if($examen_paciente->profesional)Lic. {{ $examen_paciente->profesional->name() }}@endif</td>
            </tr>
            <tr>
                <th  style="line-height: 5px"> @if($examen_paciente->invoices->factura->customer->origin_center==true)Centro de Origen:@else Cliente: @endif</th>
                <td  style="line-height: 5px">{{ $examen_paciente->invoices->factura->customer->name }}</td>
                <th  style="line-height: 5px">Impresión:</th>
                {{--<td>Lic. Yasmin Arevalo de Perez</td>--}}
                <td  style="line-height: 5px">{{ \Carbon\Carbon::now()->format('d-m-Y \/ h:i a')}}</td>
            </tr>
            </tbody>
        </table>

    </div>
    <p style="margin-top: 35px; font-size: 15px; margin-left: 5px"><b>AREA:</b> {{ $examen->exam_category->name }} / <b>PRUEBA:</b> {{ $examen->display_name }} / <b>MUESTRA:</b> {{ $examen->sample->display_name }}</p>
    <hr style="color: #756b6b; background: #756b6b; border: 1px solid #AFAFAF; margin-top: -9px; margin-bottom: -5px"/>
</div>