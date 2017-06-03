<div id="modal_price" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Precios por sucusal</h4>
            </div>
            <form class="form-horizontal form-label-left" action="{{ url('perfiles/store/prices') }}"
                  method="POST">
                {{ csrf_field() }}
                <div class="">
                    <input type="hidden" name="profile_id" value="{{ $perfil->id }}" readonly required>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12">Sucursal
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input placeholder="Precio" class="form-control col-md-7 col-xs-12"
                                       style="background: none;border: none;box-shadow: none" disabled>
                            </div>
                        </div>
                    </div>
                    @foreach($sucursales as $sucursal)
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12">{{$sucursal->display_name}}
                                </label>
                                <input type="hidden" required readonly name="sucursal_id[]"
                                       value="{{$sucursal->id}}">
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    @php $perfil_precio=$perfil->sucursales
                                               ->where('id',$sucursal->id)->first() @endphp
                                    <input type="number" min="0.0" step="0.01" name="price[]" placeholder="USD"
                                           value="@if($perfil_precio){{$perfil_precio->pivot->price}}@endif"
                                           class="form-control col-md-7 col-xs-12" required>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>