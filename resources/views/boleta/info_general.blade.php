<div class="row" >
    <div class="col-sm-12" id="general"
         style="border-radius: 15px; border: solid 1px; padding-left: 15px; margin-top: -15px" >
        <table class="table" style=" margin-top: 2px; margin-bottom: 2px; line-height: 12px; font-size: 13px; font-family: 'Helvetica Neue Light', 'HelveticaNeue-Light', 'Helvetica Neue', Calibri, Helvetica, Arial, sans-serif" >
            <tbody>
            <tr style="margin-top: 20px">
                <th>Paciente:</th>
                <td  style="width: 300px; "> @if($examen_paciente->paciente_id==null){{ $examen_paciente->paciente_nombre }}
                    @else {{ $examen_paciente->paciente->nombre }} {{ $examen_paciente->paciente->apellido }}@endif </td>
                <th  >Solicitud N°:</th>
                <td style="color: red" ><b> {{ $examen_paciente->numero_boleta }}</b></td>

            </tr>
            <tr>
                <th  >Edad:</th>
                <td  >@if($examen_paciente->paciente_id==null) @if($examen_paciente->paciente_edad){{ $examen_paciente->paciente_edad }} años @else <b style="color: #cc0000">No se brindó</b> @endif @endif  </td>
                <th  >Fecha:</th>
                <td  > @php setlocale(LC_TIME, 'es_SV.UTF-8', 'es') @endphp {{ strftime("%d de %B de %Y", \Carbon\Carbon::parse($examen_paciente->fecha_validado)->timestamp)}} </td>
            </tr>
            <tr>

                <th  >Sexo:</th>
                <td  >@if($examen_paciente->paciente_id==null) @if($examen_paciente->paciente_sexo=='M')Masculino @else Femenino @endif @endif</td>
                <th  >Validado por:</th>
                {{--<td>Lic. Yasmin Arevalo de Perez</td>--}}
                <td  >@if($examen_paciente->profesional)Lic. {{ $examen_paciente->profesional->name() }}@endif</td>
            </tr>
            <tr>
                <th  > @if($examen_paciente->invoices->factura->customer->origin_center==true)Centro de Origen:@else Cliente: @endif</th>
                <td  >{{ $examen_paciente->invoices->factura->customer->name }}</td>
                <th  >Impresión:</th>
                {{--<td>Lic. Yasmin Arevalo de Perez</td>--}}
                <td  >{{ \Carbon\Carbon::now()->format('d-m-Y \/ h:i a')}}</td>
            </tr>
            </tbody>
        </table>

    </div>
    <p style="margin-top: 5px; font-size: 15px"><b>AREA:</b> {{ $examen->exam_category->name }} / <b>PRUEBA:</b> {{ $examen->display_name }} / <b>MUESTRA:</b> {{ $examen->sample->display_name }}</p>
    <hr style="color: #756b6b; background: #756b6b; border: 1px solid #AFAFAF; margin-top: -9px"/>
</div>