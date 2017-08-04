$(document).ready(function () {
    var activo_add = $("#activo_add");

    activo_add.select2({
        placeholder: "Seleccione activo"
    });

    var t = $('#recursos').DataTable({
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

    function add_activo() {
        var activo_id = $('#activo_add').val();
        var activo_selected = $("#activo_add option:selected");
        var activo = activo_selected.text() + "<input type='hidden' name='activo_id[]' class='activo' required"
            + " value=" + activo_id + ">";
        var cantidad = "<input type='number' name='cantidad[]' placeholder='0' class='form-control' min='1' " +
            "value='1' required style='width: 100%'>";
        var del = "<div class='btn btn-danger delete'><i class='fa fa-times'></i></div>";
        //deshabilita la opcion de recurso que se está asignando al examen
        activo_selected.prop('disabled', true);
        activo_selected.removeAttr('selected');
        activo_add.select2('destroy');
        activo_add.select(0);
        activo_add.select2();
        t.row.add([activo, cantidad, del]).draw();
    }

    $("#add").submit(function (event) {
        add_activo();
        event.preventDefault();
    });

    t.on('click', 'div.delete', function () {
        var id = $(this).parents('tr').children().children('.activo').val();
        //habilita de nuevo la opcion de sucursal que se está removiendo del inventario
        var activo_removed = $("#activo_add option[value=" + id + "]");
        activo_removed.removeAttr('disabled');
        activo_removed.prop('selected', 'selected');
        activo_add.select2('destroy');
        activo_add.select(0);
        activo_add.select2();
        t.row($(this).parents('tr')).remove().draw();
    });

});