<div class="modal fade" id="modal_pago">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="modal_close" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_label">Registrar un pago</h4>
            </div>
            <form id="modal_form" method="post" action="{{url("facturas/$factura->id/payment")}}">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group hidden">
                        <label for="factura_id">ID</label>
                        <input id="factura_id" name="factura_id" class="form-control" value="{{$factura->id}}" required>
                    </div>
                    <div class="form-group">
                        <label for="numero">Número de factura</label>
                        <input id="numero" class="form-control" value="{{$factura->numero}}" readonly
                               style="width: 100%">
                    </div>
                    <div class="form-group">
                        <label for="amount">Monto del pago(USD)</label>
                        <input id="amount" name="amount" type="number" step="0.01" min="0" class="form-control"
                               style="width: 100%" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Tipo de pago</label>
                        <select id="type" name="type" class="form-control" style="width: 100%" required>
                            <option value="{{\App\Http\Controllers\FacturaController::EFECTIVO}}">Efectivo</option>
                            <option value="{{\App\Http\Controllers\FacturaController::DEBITO}}">Débito</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deuda">Deuda (USD):</label>
                        <input id="deuda" type="number" step="0.01" min="0" value="0.00" disabled
                               style="background: none;border: none;box-shadow: none">
                    </div>
                    <div class="form-group">
                        <label for="total">TOTAL(USD): </label>
                        <input id="total" disabled value="{{$total}}"
                               style="background: none;border: none;box-shadow: none">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Registrar">
                </div>
            </form>
        </div>
    </div>
</div>