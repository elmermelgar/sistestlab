<div class="modal fade" id="modal_examen">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="modal_close" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_label">Exámen</h4>
            </div>
            <form id="modal_form" method="post" action="">

                <div class="modal-body">
                    <div class="form-group hidden">
                        <label for="id">ID</label>
                        <input id="id" name="id" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="modal_examen_id">Exámen</label>
                        <select id="modal_examen_id" name="modal_examen_id" class="form-control"
                                style="width: 100%">
                        </select>
                    </div>
                    <div class="form-group hidden">
                        <label for="modal_examen_name">Nombre Exámen</label>
                        <input id="modal_examen_name" name="modal_examen_name" class="form-control"
                               style="width: 100%">
                    </div>
                    <div class="form-group hidden">
                        <label for="modal_examen_price">Precio Exámen</label>
                        <input id="modal_examen_price" name="modal_examen_price" class="form-control"
                               style="width: 100%">
                    </div>
                    <div class="form-group">
                        <label for="modal_nombre">Nombre del paciente</label>
                        <input id="modal_nombre" name="modal_nombre" class="form-control" style="width: 100%"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="modal_edad">Edad del paciente (años)</label>
                        <input type="number" id="modal_edad" name="modal_edad" class="form-control"
                               min="0" max="120" style="width: 100%" required>
                    </div>
                    <div class="form-group">
                        <label for="modal_genero">Género del paciente</label>
                        <select id="modal_genero" name="modal_genero" class="form-control"
                                style="width: 100%" required>
                            <option value="" disabled selected>Seleccione género</option>
                            <option value="F">Femenino</option>
                            <option value="M">Masculino</option>
                        </select>
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