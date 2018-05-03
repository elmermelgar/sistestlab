@php $result3=DB::table('exam_details')->where([
                                                                 ['grouping_id', '=', $group->id],
                                                                    ['reference_type_id', '=', $detail->referenceType->id],])->get();
$cuenta3 = count($result3);
@endphp
@if($con_v==1)
    <div class="row">
        <table class="table" id="imp_proto" style="margin-bottom: -23px; font-size: 12px">
            <thead style="background:#AFAFAF; color: #FFFFFF">
            <tr id="tr_proto" >

                <th style="line-height: 5px">PARAMETRO</th>
                <th style="text-align: center; line-height: 5px">RESULTADO</th>
                <th id="th_x" style="text-align: center; line-height: 5px">UNIDADES</th>
                <th id="th_x" style="text-align: center; line-height: 5px">VALORES DE REFERENCIA</th>
                <th id="th_x" style="text-align: center; line-height: 5px">OBSERVACIÓN</th>
            </tr>
            </thead>
            <tbody>
            @endif
            <tr id="tr_proto" >
                <td style="line-height: 0px; width: 30%;" id="imp_proto">{{ $detail->name_detail }}</td>
                @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],])->first();
                $ref=DB::table('reference_values')->where([
                                                 ['exam_detail_id', '=', $detail->id],])->get();
                @endphp
                <td style="text-align: center; line-height: 0px;  width: 20%;" id="imp_proto">@if($result){{ $result->result }}@endif</td>
                <td style="text-align: center; line-height: 0px;   width: 10%;" id="imp_proto">
                    @if($ref)
                        @foreach($ref as $r)
                            @if($examen_paciente->paciente_edad!=null)
                                @if($examen_paciente->paciente_genero=='M')
                                    @if($r->gender=='Masculino')
                                        @if(($examen_paciente->paciente_edad)<=($r->edad_mayor) and ($examen_paciente->paciente_edad)>=($r->edad_menor))
                                            {{ $r->unidades }}
                                        @endif
                                    @else
                                        {{ $r->unidades }}
                                    @endif
                                @endif

                                @if($examen_paciente->paciente_genero=='F')
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
                <td style="text-align: center; line-height: 0px; width: 22%;" id="imp_proto">
                    @if($ref)
                        @foreach($ref as $r)
                            @if($examen_paciente->paciente_edad!=null)
                                @if($examen_paciente->paciente_genero=='M')
                                    @if($r->gender=='Masculino')
                                        @if(($examen_paciente->paciente_edad)<=($r->edad_mayor) and ($examen_paciente->paciente_edad)>=($r->edad_menor))
                                            {{ $r->value }}
                                        @endif
                                    @else
                                        {{ $r->value }}
                                    @endif

                                @endif

                                @if($examen_paciente->paciente_genero=='F')
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