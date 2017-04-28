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
                        <label for="id">ID</label>
                        <input id="id" name="id" class="form-control" value="{{$factura->id}}" required>
                    </div>
                    <div class="form-group">
                        <label for="credito_fiscal">Crédito Fiscal </label>
                        <input id="credito_fiscal" name="credito_fiscal" type="checkbox" class="custom-check"
                               @if($factura) checked @endif>
                    </div>
                    <div class="form-group">
                        <label for="numero">Número de factura</label>
                        <input id="numero" name="numero" maxlength="8" step="0.01" min="0" class="form-control"
                               style="width: 100%" value="{{$factura->numero}}">
                    </div>
                    <div class="form-group">
                        <label for="efectivo">Efectivo (USD)</label>
                        <input id="efectivo" name="efectivo" type="number" step="0.01" min="0" class="form-control"
                               style="width: 100%" required value="{{$factura->efectivo}}">
                    </div>
                    <div class="form-group">
                        <label for="debito">Debito (USD)</label>
                        <input id="debito" name="debito" class="form-control" type="number" step="0.01" min="0"
                               style="width: 100%" required value="{{$factura->debito}}">
                    </div>
                    <div class="form-group">
                        <label for="deuda">Deuda (USD)</label>
                        <input id="deuda" name="deuda" class="form-control" type="number" step="0.01" min="0"
                               style="width: 100%" required value="{{$factura->deuda}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-primary" value="Facturar">
                </div>
            </form>
        </div>
    </div>
</div>