$(document).ready(function () {
    var sucursal_add = $("#sucursal_add");
    var t = $('#inventario').DataTable({
        bFilter: false,
        paging: false,
        info: false,
        "language": {
            "search": "Buscar:",
            "info": "Mostrando _END_ de _TOTAL_ entradas",
            "infoEmpty": "Mostrando 0 de 0 entradas",
            "zeroRecords": "Sin registros"
        }
    });

    function add_sucursal() {
        var sucursal_id = $('#sucursal_add').val();
        var sucursal_selected = $("#sucursal_add option:selected");
        var sucursal = sucursal_selected.text() + "<input type='hidden' name='sucursal_id[]' class='sucursal' required"
            + " value=" + sucursal_id + ">";
        var estado = "<select id='estado" + sucursal_id + "' name='estado_id[]' style='width: 100%' class='form-control'>"
            + $("#estado_add").html() + "</select>";
        var ubicacion = "<input name='ubicacion[]' class='form-control' style='width: 100%' " +
            "placeholder='¿Dónde está ubicado?' required maxlength='255'>";
        var minimo = "<input type='number' name='minimo[]' placeholder='0' class='form-control' min='1' " +
            "value='1' required style='width: 100%'>";
        var maximo = "<input type='number' name='maximo[]' placeholder='0' class='form-control' min='1' " +
            "value='100' required style='width: 100%'>";
        var del = "<div class='btn btn-danger delete'><i class='fa fa-times'></i></div>";
        //deshabilita la opcion de sucursal que se está agregando al inventario
        sucursal_selected.prop('disabled', true);
        sucursal_selected.removeAttr('selected');
        t.row.add([sucursal, estado, ubicacion, minimo, maximo, del]).draw();
    }

    $("#add").submit(function (event) {
        add_sucursal();
        event.preventDefault();
    });

    t.on('click', 'div.delete', function () {
        var id = $(this).parents('tr').children().children('.sucursal').val();
        //habilita de nuevo la opcion de sucursal que se está removiendo del inventario
        var sucursal_removed = $("#sucursal_add option[value=" + id + "]");
        sucursal_removed.removeAttr('disabled');
        sucursal_removed.prop('selected', 'selected');
        t.row($(this).parents('tr')).remove().draw();
    });

});