<div class="modal fade" id="modal_nivel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="modal_close" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span></button>
                <h4 class="modal-title">Aplicar un recargo o descuento</h4>
            </div>
            <form id="modal_form" method="post" action="{{url("facturas/$factura->id/nivel")}}">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group hidden">
                        <input type="hidden" name="factura_id" class="form-control" value="{{$factura->id}}" required>
                    </div>
                    <p>Indique un porcentaje <i style="color: red">negativo para un descuento</i>
                        o un porcentaje <i style="color: green;">positivo para un recargo.</i></p>
                    @if($factura->nivel!=0)
                        <p>Nivel aplicado actualmente: {{$factura->nivel*100}}%</p>
                        <p>Monto (USD): {{number_format($nivel_monto,2)}}</p>
                    @endif
                    <div class="form-group">
                        <label for="nivel">Porcentaje</label>
                        <br><br>
                        <input id="nivel" name="nivel"
                               data-slider-min="-1"
                               data-slider-max="1"
                               data-slider-step="0.05"
                               data-slider-value="{{$factura->nivel}}"
                               data-slider-tooltip="always"
                               data-slider-handle="square"
                               class="form-control" style="width: 100%" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Aplicar">
                </div>
            </form>
        </div>
    </div>
</div>