@php $result=DB::table('exam_details')->where([
                                                                 ['grouping_id', '=', $group->id],
                                                                    ['reference_type_id', '=', $detail->referenceType->id],])->get();
$cuenta = count($result);
@endphp

    @if($ind==1)
    <div class="col-md-12" id="proto_panel">
        <div class="row">
            <table class="table ">
                <thead>
                <tr id="tr_proto">

                    <th  style="line-height: 5px;">PROTOZOARIO</th>
                    <th  style="text-align: center; line-height: 5px;">QUISTES</th>
                    <th  style="text-align: center; line-height: 5px;">ACTIVOS</th>
                </tr>
                </thead>
                <tbody>
    @endif
                <tr >
                    <td  style="line-height: 0px;">{{ $detail->name_detail }}</td>
                    @foreach($proto_types as $type)
                        @if($type->name != 'Ninguno')
                            @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],
                                                                    ['protozoarios_type_id', '=', $type->id],])->first();
                            @endphp


                            <td  style="text-align: center; line-height: 0px;">@if($result){{ $result->result }}@endif</td>
                            {{--<td style="text-align: center">No se observan</td>--}}

                        @endif
                    @endforeach
                </tr>
    @if($ind==$cuenta)
                </tbody>
            </table>

        </div>
    </div>
    @endif

