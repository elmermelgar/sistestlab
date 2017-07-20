{{-- Inicio Modal para guardar Registros de antibioticos--}}
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Nuevo Antibiótico</h4>
            </div>
            <form class="form-horizontal form-label-left" action="{{ url('results/storeantibiotico') }}"
                  method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" name="examen_paciente_id" value="{{ $examen_paciente->id }}">
                    {{--Parte 1--}}
                    <fieldset>
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12">Antibiótico:
                                </label>

                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select  name="antibiotico_id" class="form-control" required>
                                        @foreach($antibioticos as $antibiotico)
                                            <option value="{{$antibiotico->id}}">{{$antibiotico->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12">Tipo:
                                </label>

                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select name="antibiotico_type_id" class="form-control" required>
                                        @foreach($antibiotico_types as $antibiotico_type)
                                            <option value="{{$antibiotico_type->id}}">{{$antibiotico_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Fin Modal para guardar Registros de antibioticos--}}