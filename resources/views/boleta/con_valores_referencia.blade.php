@php $result3=DB::table('exam_details')->where([
                                                                 ['grouping_id', '=', $group->id],
                                                                    ['reference_type_id', '=', $detail->referenceType->id],])->get();
$cuenta3 = count($result3);
@endphp
@if($con_v==1)
    <div class="row">
        <table id="table_result" style="margin-top: -4px; font-size: 12px; width: 100%; border-radius: 5px; border-collapse: collapse;">
            <thead style="background:#AFAFAF; color: #FFFFFF">
            <tr>
                <th colspan="5" style="background: #FFFFFF; color: #000000; border-bottom: double 3px #756b6b"><h3 style="margin-bottom: 0px; margin-top: 2px"><b>@if($group->name!='default'){{ $group->name }}@endif</b></h3></th>
            </tr>
            <tr id="tr_proto" style="background: #AFAFAF; font-size: 10px">

                <th>PARAMETRO</th>
                <th style="text-align: center; ">RESULTADO</th>
                <th id="th_x" style="text-align: center; ">UNIDADES</th>
                <th id="th_x" style="text-align: center; ">VALORES DE REFERENCIA</th>
                <th id="th_x" style="text-align: center;">OBSERVACIÓN</th>
            </tr>
            </thead>
            <tbody>
            @endif
            <tr id="tr_proto" >
                <td style="width: 22%;" id="imp_proto">{{ $detail->name_detail }}</td>
                @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],])->first();
                $ref=DB::table('reference_values')->where([
                                                 ['exam_detail_id', '=', $detail->id],])->get();
                @endphp
                <td style="text-align: center;width: 20%;" id="imp_proto">@if($result){{ $result->result }}@if($result->out_range==true)<b style="color: #cc0000">*</b>@endif @endif</td>
                <td style="text-align: center;width: 12%;" id="imp_proto">
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
                <td style="text-align: center; line-height: 0px; width: 20%;" id="imp_proto">
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
        <hr style="color: #756b6b; background: #756b6b; border: 1px solid #AFAFAF; margin-top: -1px"/>
    </div>
@endif