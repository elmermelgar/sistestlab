<div class="modal fade" id="modal_facturar">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="modal_close" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_label">Facturar</h4>
            </div>
            <form id="modal_form" method="post" action="{{url("facturas/$factura->id/facturar")}}">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group hidden">
                        <label for="factura_id">ID</label>
                        <input type="hidden" id="factura_id" name="factura_id" class="form-control"
                               value="{{$factura->id}}" required>
                    </div>
                    <div class="form-group hidden">
                        <label for="sucursal_idfactura_id">Sucursal</label>
                        <input type="hidden" id="sucursal_id" name="sucursal_id" class="form-control"
                               value="{{$factura->sucursal->id}}" required>
                    </div>
                    <div class="form-group">
                        <label for="credito_fiscal">Crédito Fiscal </label>
                        <input id="credito_fiscal" name="credito_fiscal" type="checkbox" class="custom-check"
                               @if($factura->credito_fiscal) checked @endif>
                    </div>
                    <div class="form-group">
                        <label for="numero">Número de factura</label>
                        <input id="numero" name="numero" maxlength="8" step="0.01" min="0" class="form-control"
                               style="width: 100%" value="{{$factura->numero}}">
                    </div>
                    <div class="form-group">
                        <label for="facturar_monto">Monto del pago(USD)</label>
                        <input id="facturar_monto" name="amount" type="number" step="0.01" min="0" class="form-control"
                               style="width: 100%" required>
                    </div>
                    <div class="form-group">
                        <label for="facturar_tipo">Tipo de pago</label>
                        <select id="facturar_tipo" name="type" class="form-control" style="width: 100%" required>
                            <option value="{{\App\Transaction::EFECTIVO}}">Efectivo</option>
                            <option value="{{\App\Transaction::DEBITO}}">Débito</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="facturar_deuda">Deuda (USD):</label>
                        <input id="facturar_deuda" type="number" step="0.01" min="0" value="0.00" disabled
                               style="background: none;border: none;box-shadow: none">
                    </div>
                    <div class="form-group">
                        <label for="facturar_total">TOTAL(USD): </label>
                        <input id="facturar_total" disabled value="{{$total}}"
                               style="background: none;border: none;box-shadow: none">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Facturar">
                </div>
            </form>
        </div>
    </div>
</div>