<div class="col-md-12" id="antibioticos">

    <div class="row">
        <table class="table " style="margin-top: 10px; margin-right: auto; margin-left: auto; font-size: 12px; width: 60%; border-radius: 5px; border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="3" style="background: #FFFFFF; color: #000000; border-bottom: double 3px #756b6b"><h3 style="margin-bottom: -3px; margin-top: 0"><b>ANTIBIÓTICOS</b></h3></th>
            </tr>
            <tr style="background:#AFAFAF; color: #FFFFFF">

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
        <hr style="color: #756b6b; background: #756b6b; border: 1px solid #AFAFAF; margin-top: -1px; width: 60%"/>
    </div>
</div>