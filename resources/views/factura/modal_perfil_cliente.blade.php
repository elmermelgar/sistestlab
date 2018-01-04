<div class="modal fade" id="modal_profile">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="modal_close" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_label">Agregar un perfil o examen a la factura</h4>
            </div>
            <form id="modal_form" method="post" action="">

                <div class="modal-body">
                    <div class="form-group hidden">
                        <label for="id">ID</label>
                        <input id="id" name="id" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="modal_profile_id">Perfil o examen</label>
                        <select id="modal_profile_id" name="modal_profile_id" class="form-control"
                                required style="width: 100%">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modal_paciente_id">Paciente</label>
                        <select id="modal_paciente_id" name="modal_paciente_id" class="form-control" required
                                style="width: 100%">
                        </select>
                    </div>
                    <div class="form-group hidden">
                        <input type="hidden" id="modal_profile_name" name="modal_profile_name">
                        <input type="hidden" id="modal_profile_display_name" name="modal_profile_display_name">
                        <input type="hidden" id="modal_profile_price" name="modal_profile_price">
                        <input type="hidden" id="modal_nombre" name="modal_nombre">
                        <input type="hidden" id="modal_edad" name="modal_edad">
                        <input type="hidden" id="modal_sexo" name="modal_sexo">
                    </div>

                    <div class="form-group">
                        <label for="modal_numero_boleta">Número de boleta</label>
                        <input id="modal_numero_boleta" name="modal_numero_boleta" class="form-control" maxlength="8"
                               style="width: 100%" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-primary" value="Agregar">
                </div>
            </form>
        </div>
    </div>
</div>