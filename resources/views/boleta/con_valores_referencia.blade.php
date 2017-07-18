@php $result3=DB::table('exam_details')->where([
                                                                 ['grouping_id', '=', $group->id],
                                                                    ['reference_type_id', '=', $detail->referenceType->id],])->get();
$cuenta3 = count($result3);
@endphp
@if($con_v==1)
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>

                <th style="text-align: center">Parametro</th>
                <th style="text-align: center">Resultado</th>
                <th style="text-align: center">Unidades</th>
                <th style="text-align: center">Valores de Referencia</th>
                <th style="text-align: center">Observación</th>
            </tr>
            </thead>
            <tbody>
            @endif
            <tr>
                <td style="text-align: center">{{ $detail->name_detail }}</td>
                @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],])->first();
                $ref=DB::table('reference_values')->where([
                                                 ['exam_detail_id', '=', $detail->id],])->get();
                @endphp
                <td style="text-align: center">{{ $result->result }}</td>
                <td style="text-align: center">
                    @if($ref)
                        @foreach($ref as $r)
                            @if($examen_paciente->paciente_edad!=null)
                                @if($examen_paciente->paciente_genero=='M')
                                    @if($r->gender=='Masculino')
                                        @if(($examen_paciente->paciente_edad)<=($r->edad_mayor) and ($examen_paciente->paciente_edad)>=($r->edad_menor))
                                            {{ $r->unidades }}
                                        @endif
                                    @endif
                                @endif

                                @if($examen_paciente->paciente_genero=='F')
                                    @if($r->gender=='Femenino')
                                        @if(($examen_paciente->paciente_edad)<=($r->edad_mayor) and ($examen_paciente->paciente_edad)>=($r->edad_menor))
                                            {{ $r->unidades }}
                                        @endif
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
                <td style="text-align: center">
                    @if($ref)
                        @foreach($ref as $r)
                            @if($examen_paciente->paciente_edad!=null)
                                @if($examen_paciente->paciente_genero=='M')
                                    @if($r->gender=='Masculino')
                                        @if(($examen_paciente->paciente_edad)<=($r->edad_mayor) and ($examen_paciente->paciente_edad)>=($r->edad_menor))
                                            {{ $r->value }}
                                        @endif
                                    @endif
                                @endif

                                @if($examen_paciente->paciente_genero=='F')
                                    @if($r->gender=='Femenino')
                                        @if(($examen_paciente->paciente_edad)<=($r->edad_mayor) and ($examen_paciente->paciente_edad)>=($r->edad_menor))
                                            {{ $r->value }}
                                        @endif
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
                <td style="text-align: center">{{ $result->observation }}</td>
            </tr>
            @if($con_v==$cuenta3)
            </tbody>
        </table>

    </div>
@endif