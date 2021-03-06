@php $result2=DB::table('exam_details')->where([
                                                                 ['grouping_id', '=', $group->id],
                                                                    ['reference_type_id', '=', $detail->referenceType->id],])->get();
$cuenta2 = count($result2);
@endphp
@if($esp==1)
<div class="col-md-12" id="proto_panel">
    <div class="row">
        <table id="table_result" style="margin-top: -4px; font-size: 12px; width: 100%; border-radius: 5px; border-collapse: collapse;">
            <thead style="background:#AFAFAF; color: #FFFFFF">
            <tr>
                <th colspan="5" style="background: #FFFFFF; color: #000000; border-bottom: double 3px #756b6b"><h3 style="margin-bottom: 0px; margin-top: 2px"><b>@if($group->name!='default'){{ $group->name }}@endif</b></h3></th>
            </tr>
            <tr id="tr_proto" style="background: #AFAFAF; font-size: 10px">

                <th >PARÁMETRO</th>
                <th style="text-align: center;">1 Hora</th>
                <th style="text-align: center;">2 Horas</th>
                <th style="text-align: center;">3 Horas</th>
                <th style="text-align: center;">4 Horas</th>
            </tr>
            </thead>
            <tbody>
 @endif
            <tr>
                <td >{{ $detail->name_detail }}</td>
                @foreach($sperm_types as $type)
                    @if($type->name != 'Ninguno')
                        @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],
                                                                    ['spermogram_modality_id', '=', $type->id],])->first();
                        @endphp
                <td style="text-align: center;">@if($result){{ $result->result }}@endif</td>
                    @endif
                @endforeach
            </tr>
 @if($esp==$cuenta2)
            </tbody>
        </table>
        <hr style="color: #756b6b; background: #756b6b; border: 1px solid #AFAFAF; margin-top: -1px; width: 100%"/>
    </div>
</div>
@endif