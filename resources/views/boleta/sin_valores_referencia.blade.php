@if($detail->referenceType->name == 'ninguno')
    <div class="col-md-6" id="sin_val">
        <ul class="list-inline widget_tally">
            @php $result=DB::table('results')->where([
                                                                 ['exam_detail_id', '=', $detail->id],
                                                                    ['examen_paciente_id', '=', $examen_paciente->id],])->first();
            @endphp
            <li>
                <p>
                    <span class="month"><b>{{ $detail->name_detail }}:</b></span>
                    <span class="count">@if($result){{ $result->result }}@endif</span>
                </p>
            </li>
            @if($result)
            @if($result->observation!='')
            <li>
                <p>
                    <span class="obs">Observación: @if($result) {{ $result->observation }}@endif</span>
                </p>
            </li>
                @endif
            @endif

        </ul>
    </div>

@endif