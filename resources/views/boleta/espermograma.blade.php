@php $result2=DB::table('exam_details')->where([
                                                                 ['grouping_id', '=', $group->id],
                                                                    ['reference_type_id', '=', $detail->referenceType->id],])->get();
$cuenta2 = count($result2);
@endphp
@if($esp==1)
<div class="col-md-12" id="proto_panel">
    <div class="row">
        <table class="table ">
            <thead>
            <tr id="tr_proto">

                <th style="line-height: 5px;">MODALIDAD</th>
                <th style="line-height: 5px;">1 Hora</th>
                <th style="line-height: 5px;">2 Horas</th>
                <th style="line-height: 5px;">3 Horas</th>
                <th style="line-height: 5px;">4 Horas</th>
            </tr>
            </thead>
            <tbody>
 @endif
            <tr>
                <td style="line-height: 0px;">{{ $detail->name_detail }}</td>
                @foreach($sperm_types as $type)
                    @if($type->name != 'Ninguno')
                        @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],
                                                                    ['spermogram_modality_id', '=', $type->id],])->first();
                        @endphp
                <td style="text-align: center; line-height: 0px;">@if($result){{ $result->result }}@endif</td>
                    @endif
                @endforeach
            </tr>
 @if($esp==$cuenta2)
            </tbody>
        </table>

    </div>
</div>
@endif