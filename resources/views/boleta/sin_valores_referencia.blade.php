@php $result4=DB::table('exam_details')->where([
                                               ['grouping_id', '=', $group->id],
                                               ['reference_type_id', '=', $detail->referenceType->id],])->get();
$cuenta4=count($result4);
@endphp

@if($sin_v==1)
    <div class="col-md-6" >

            <table id="table_result" style="margin-top: 10px; margin-left: auto;margin-right: auto; font-size: 12px; width: 60%; border-radius: 5px; border-collapse: collapse;">
                <thead style="background:#AFAFAF; color: #FFFFFF">
                <tr>
                    <th colspan="2" style="background: #FFFFFF; color: #000000; border-bottom: double 3px #756b6b"><h3 style="margin-bottom: -3px; margin-top: 0"><b>@if($group->name!='default'){{ $group->name }}@endif</b></h3></th>
                </tr>
                <tr id="tr_proto" style="background: #AFAFAF; font-size: 10px">

                    <th>PARAMETRO</th>
                    <th >RESULTADO</th>
                    {{--@if($result)--}}
                        {{--@if($result->observation!='')--}}
                            {{--<th >OBSERVACIÓN</th>--}}
                        {{--@endif--}}
                    {{--@endif--}}

                </tr>
                </thead>
                <tbody>
    @endif
                <tr id="tr_proto" >
                    @php $result=DB::table('results')->where([
                                                             ['exam_detail_id', '=', $detail->id],
                                                             ['examen_paciente_id', '=', $examen_paciente->id],])->first();
                    @endphp
                    <td ><b>{{ $detail->name_detail }}:</b></td>
                    <td >@if($result){{ $result->result }}@endif</td>
                    {{--@if($result)--}}
                        {{--@if($result->observation!='')--}}
                            {{--<td style="width: 22%;" id="imp_proto"><span class="obs">Observación: @if($result) {{ $result->observation }}@endif</span></td>--}}
                        {{--@endif--}}
                    {{--@endif--}}
                </tr>
    @if($sin_v==$cuenta4)

                </tbody>
            </table>
        {{--<br/>--}}
        <hr style="color: #756b6b; background: #756b6b; border: 1px solid #AFAFAF; margin-top: -1px; width: 60%"/>

    </div>
    @endif


