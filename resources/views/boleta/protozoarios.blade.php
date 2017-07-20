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
                <tr>

                    <th>PROTOZOARIO</th>
                    <th style="text-align: center">QUISTES</th>
                    <th style="text-align: center">ACTIVOS</th>
                </tr>
                </thead>
                <tbody>
    @endif
                <tr>
                    <td>{{ $detail->name_detail }}</td>
                    @foreach($proto_types as $type)
                        @if($type->name != 'Ninguno')
                            @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],
                                                                    ['protozoarios_type_id', '=', $type->id],])->first();
                            @endphp


                            <td style="text-align: center">{{ $result->result }}</td>
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

