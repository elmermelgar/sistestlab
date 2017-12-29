@php $result3=DB::table('exam_details')->where([
                                                                 ['grouping_id', '=', $group->id],
                                                                    ['reference_type_id', '=', $detail->referenceType->id],])->get();
$cuenta3 = count($result3);
@endphp
@if($con_v==1)
    <div class="row">
        <table class="table" id="imp_proto" style="margin-bottom: -23px; font-size: 12px">
            <thead>
            <tr id="tr_proto">

                <th id="th_x" style="line-height: 5px;background:#e0e0e0">Parametro</th>
                <th id="th_x" style="text-align: center; line-height: 1px;background:silver">Resultado</th>
                <th id="th_x" style="text-align: center; line-height: 1px;background:#e0e0e0">Unidades</th>
                <th id="th_x" style="text-align: center; line-height: 1px;background:#e0e0e0">Valores de Referencia</th>
                <th id="th_x" style="text-align: center; line-height: 1px;background:#e0e0e0">Observación</th>
            </tr>
            </thead>
            <tbody>
            @endif
            <tr id="tr_proto" >
                <td style="line-height: 0px; width: 25%;" id="imp_proto">{{ $detail->name_detail }}</td>
                @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],])->first();
                $ref=DB::table('reference_values')->where([
                                                 ['exam_detail_id', '=', $detail->id],])->get();
                @endphp
                <td style="text-align: center; line-height: 0px;  width: 10%;" id="imp_proto">@if($result){{ $result->result }}@endif</td>
                <td style="text-align: center; line-height: 0px;   width: 10%;" id="imp_proto">
                    @if($ref)
                        @foreach($ref as $r)
                            @if($examen_paciente->paciente_edad!=null)
                                @if($examen_paciente->paciente_sexo=='M')
                                    @if($r->gender=='Masculino')
                                        @if(($examen_paciente->paciente_edad)<=($r->edad_mayor) and ($examen_paciente->paciente_edad)>=($r->edad_menor))
                                            {{ $r->unidades }}
                                        @endif
                                    @else
                                        {{ $r->unidades }}
                                    @endif
                                @endif

                                @if($examen_paciente->paciente_sexo=='F')
                                    @if($r->gender=='Femenino')
                                        @if(($examen_paciente->paciente_edad)<=($r->edad_mayor) and ($examen_paciente->paciente_edad)>=($r->edad_menor))
                                            {{ $r->unidades }}
                                        @endif
                                        @else
                                            {{ $r->unidades }}
                                        @endif
                                @endif

                            @else
                                @if($r->gender=='Default')
                                    {{ $r->unidades }}
                                @endif
                            @endif
                        @endforeach
                    @else
                        ---
                    @endif
                </td>
                <td style="text-align: center; line-height: 0px; width: 18%;" id="imp_proto">
                    @if($ref)
                        @foreach($ref as $r)
                            @if($examen_paciente->paciente_edad!=null)
                                @if($examen_paciente->paciente_sexo=='M')
                                    @if($r->gender=='Masculino')
                                        @if(($examen_paciente->paciente_edad)<=($r->edad_mayor) and ($examen_paciente->paciente_edad)>=($r->edad_menor))
                                            {{ $r->value }}
                                        @endif
                                    @else
                                        {{ $r->value }}
                                    @endif

                                @endif

                                @if($examen_paciente->paciente_sexo=='F')
                                    @if($r->gender=='Femenino')
                                        @if(($examen_paciente->paciente_edad)<=($r->edad_mayor) and ($examen_paciente->paciente_edad)>=($r->edad_menor))
                                            {{ $r->value }}
                                        @endif
                                    @else
                                        {{ $r->value }}
                                    @endif
                                @endif

                            @else
                                @if($r->gender=='Default')
                                {{ $r->value }}
                                @endif
                            @endif
                        @endforeach
                    @else
                        No posee Valores de referencia
                    @endif
                </td>
                <td style="text-align: center; line-height: 0px;" id="imp_proto">{{ $result->observation }}</td>
            </tr>
            @if($con_v==$cuenta3)
            </tbody>
        </table>

    </div>
@endif