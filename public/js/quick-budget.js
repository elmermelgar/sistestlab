$(document).ready(function () {
    $('#perfil_add').select2();

    var t = $('#budget').DataTable({
        bFilter: false,
        paging: false,
        info: false,
        order: [[1, 'asc']],
        "language": {
            "search": "Buscar:",
            "info": "Mostrando _END_ de _TOTAL_ entradas",
            "infoEmpty": "Mostrando 0 de 0 entradas",
            "zeroRecords": "Sin registros"
        }
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    function add_perfil() {
        var perfil_id = $('#perfil_add').val();
        var perfil_selected = $("#perfil_add option:selected");
        var perfil = perfil_selected.text() + "<input type='hidden' name='perfiles[]' class='perfiles' required"
            + " value=" + perfil_id + ">";
        var cantidad = "<input type='number' name='cantidades[]' placeholder='0' class='form-control' min='1' step='1'" +
            "value='1' required style='width: 100%'>";

        var del = "<div class='btn btn-danger delete'><i class='fa fa-times'></i></div>";
        //deshabilita la opcion de sucursal que se está agregando al inventario
        perfil_selected.prop('disabled', true);
        perfil_selected.removeAttr('selected');
        t.row.add([null, perfil, cantidad, del]).draw();
        $('#perfil_add').select2("destroy");
        $('#perfil_add').select2();
    }

    $("#add").submit(function (event) {
        add_perfil();
        event.preventDefault();
    });

    t.on('click', 'div.delete', function () {
        var id = $(this).parents('tr').children().children('.perfiles').val();
        //habilita de nuevo la opcion de sucursal que se está removiendo del inventario
        var perfil_removed = $("#perfil_add option[value=" + id + "]");
        perfil_removed.removeAttr('disabled');
        perfil_removed.prop('selected', 'selected');
        t.row($(this).parents('tr')).remove().draw();
        $('#perfil_add').select2("destroy");
        $('#perfil_add').select2();
    });

});