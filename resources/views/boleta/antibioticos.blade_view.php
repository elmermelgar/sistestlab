<div class="col-md-12" id="antibioticos">
    <div style="border-bottom: 2px solid;padding-top:8px;border-color: silver;margin-bottom: 0px">
        <small><b>ANTIBIÓTICOS</b></small>
    </div>
    <div class="row">
        <table class="table ">
            <thead>
            <tr>

                <th style="text-align: center">SENCIBLE</th>
                <th style="text-align: center">INTERMEDIO</th>
                <th style="text-align: center">RESISTENTE</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="text-align: center">
                @foreach($registro_antibioticos as $registro_antibiotico)
                        @if($registro_antibiotico->antibiotico_type->name=='Sensible')
                            {{ $registro_antibiotico->antibiotico->name }} <a href="{{url('results/antibiotico/'.$registro_antibiotico->id)}}" id="rem_ant"><i class="fa fa-remove" title="Eliminar Antibiótico"></i></a><br/>
                        @endif
                    @endforeach
                </td>
                <td style="text-align: center">
                    @foreach($registro_antibioticos as $registro_antibiotico)
                        @if($registro_antibiotico->antibiotico_type->name=='Intermedio')
                           {{ $registro_antibiotico->antibiotico->name }} <a href="{{url('results/antibiotico/'.$registro_antibiotico->id)}}" id="rem_ant"><i class="fa fa-remove" title="Eliminar Antibiótico"></i></a><br/>
                        @endif
                    @endforeach
                </td>
                <td style="text-align: center">
                    @foreach($registro_antibioticos as $registro_antibiotico)
                        @if($registro_antibiotico->antibiotico_type->name=='Resistente')
                            {{ $registro_antibiotico->antibiotico->name }} <a href="{{url('results/antibiotico/'.$registro_antibiotico->id)}}" id="rem_ant"><i class="fa fa-remove" title="Eliminar Antibiótico"></i></a><br/>
                        @endif
                    @endforeach
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</div>