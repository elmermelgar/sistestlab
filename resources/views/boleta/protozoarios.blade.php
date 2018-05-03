@php $result=DB::table('exam_details')->where([
                                              ['grouping_id', '=', $group->id],
                                              ['reference_type_id', '=', $detail->referenceType->id],])->get();
$cuenta = count($result);
@endphp

    @if($ind==1)
    <div class="col-md-6">

            <table id="table_result" style="margin-top: 10px; margin-right: auto; margin-left: auto; font-size: 12px; width: 60%; border-radius: 5px; border-collapse: collapse;">
                <thead style="background:#AFAFAF; color: #FFFFFF">
                <tr>
                    <th colspan="3" style="background: #FFFFFF; color: #000000; border-bottom: double 3px #756b6b"><h3 style="margin-bottom: -3px; margin-top: 0"><b>@if($group->name!='default'){{ $group->name }}@endif</b></h3></th>
                </tr>
                <tr id="tr_proto" style="background:#AFAFAF; font-size: 10px">

                    <th  style="margin-bottom: -3px">PARAMETRO</th>
                    <th  style="text-align: center;">QUISTES</th>
                    <th  style="text-align: center;">ACTIVOS</th>
                </tr>
                </thead>
                <tbody>
    @endif
                <tr id="tr_proto">
                    <td  >{{ $detail->name_detail }}</td>
                    @foreach($proto_types as $type)
                        @if($type->name != 'Ninguno')
                            @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                 ['examen_paciente_id', '=', $examen_paciente->id],
                                                                 ['protozoarios_type_id', '=', $type->id],])->first();
                            @endphp

                            <td  style="text-align: center;">@if($result){{ $result->result }}@endif</td>

                        @endif
                    @endforeach
                </tr>
    @if($ind==$cuenta)
        {{--<br/>--}}
        {{--<hr style="color: #756b6b; background: #756b6b; border: 1px solid #AFAFAF; margin-top: -1px"/>--}}
                </tbody>
            </table>
            <hr style="color: #756b6b; background: #756b6b; border: 1px solid #AFAFAF; margin-top: -1px; width: 60%"/>
        {{--</div>--}}
    </div>
    @endif

