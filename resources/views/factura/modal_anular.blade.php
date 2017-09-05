<div class="modal fade" id="annulModal" tabindex="-1" role="dialog" aria-labelledby="annulModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="annulModalLabel">Anular Factura</h4>
            </div>
            <form method="post" action="{{route('factura.annul')}}">
                {{csrf_field()}}

                <div class="modal-body">
                    <div class="form-group hidden">
                        <label for="anular_factura_id">ID</label>
                        <input id="anular_factura_id" name="factura_id" class="form-control">
                    </div>
                    <div class="form-group">
                        <h5><strong>¿Está seguro de anular ésta factura?</strong></h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-danger" value="Anular">
                </div>
            </form>
        </div>
    </div>
</div>