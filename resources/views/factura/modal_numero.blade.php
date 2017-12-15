<div class="modal fade" id="modal_numero">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cambiar número de factura</h4>
            </div>
            <form id="modal_form" method="post" action="{{route('factura.numero')}}">
                {{csrf_field()}}
                <div class="modal-body">
                    <p class="red">Al realizar el cambio de número la factura <strong>{{$factura->numero}}</strong>
                        será anulada.</p>
                    <div class="form-group hidden">
                        <label for="factura_id">ID</label>
                        <input type="hidden" id="factura_id" name="factura_id" class="form-control"
                               value="{{$factura->id}}" required>
                    </div>
                    <div class="form-group">
                        <label for="numero">Nuevo número de factura</label>
                        <input id="numero" name="numero" maxlength="8" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="check_numero">
                        <label for="check_numero">Marque esta casilla si esta seguro de realizar el cambio</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input id='submit_numero' type="submit" class="btn btn-primary" value="Cambiar Número" disabled>
                </div>
            </form>
        </div>
    </div>
</div>