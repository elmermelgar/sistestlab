<div class="modal fade" id="modal_add_examen">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="modal_close" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_label">Examen</h4>
            </div>
            <form id="modal_form" method="post" action="{{url('perfiles/add_exam')}}">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group hidden">
                        <label for="profile_id">ID</label>
                        <input id="profile_id" name="profile_id" class="form-control" value="{{$perfil->id}}">
                    </div>
                    <div class="form-group">
                        <label for="exam_id">Exámen</label>
                        <select id="exam_id" name="exam_id" class="form-control"
                                style="width: 100%">
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