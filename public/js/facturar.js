$(document).ready(function () {

    var t = $('#factura').DataTable({
        paging: false,
        order: [[1, 'asc']],
        "language": {
            "search": "Buscar:",
            "info": "Mostrando _END_ de _TOTAL_ entradas",
            "infoEmpty": "Mostrando 0 de 0 entradas",
            "zeroRecords": "Sin registros"
        }
    });

    $("#recolector_id").select2({
        placeholder: "Seleccione recolector",
        minimumResultsForSearch: Infinity
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
//                    "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
            "<div class='select2-result-repository__avatar'><img src='" + "http://testlab.dev/storage/photos/user.png" + "' /></div>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.razon_social + "</div>";

        if (repo.descripcion) {
            markup += "<div class='select2-result-repository__description'>" + repo.descripcion + "</div>";
        }

        return markup;
    }

    function formatRepoSelection(repo) {
        $("#nit").val(repo.nit);
        return repo.razon_social || repo.text;
    }

    function formatRepoExam(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.display_name + "</div>";

        if (repo.precio) {
            markup += "<div class='select2-result-repository__description'>" + repo.precio + "</div>";
        }

        return markup;
    }

    function formatRepoSelectionExam(repo) {
        $('#modal_examen_name').val(repo.display_name);
        $('#modal_examen_price').val(repo.precio);
        return repo.display_name || repo.text;
    }

    $("#cliente_id").select2({
        placeholder: 'Seleccione un cliente',
        ajax: {
//                    url: "https://api.github.com/search/repositories",
            url: "/facturar/search/customer",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    razon_social: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });
    $("#modal_genero").select2({
        placeholder: "Seleccione género",
        minimumResultsForSearch: Infinity
    });
    $("#modal_examen_id").select2({
        placeholder: 'Seleccione un examen',
        ajax: {
//                    url: "https://api.github.com/search/repositories",
            url: "/facturar/search/exam",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    display_name: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepoExam,
        templateSelection: formatRepoSelectionExam
    });

    $("#modal_form").submit(function (event) {
        var examen_id = $('#modal_examen_id').val();
        var examen_name = $('#modal_examen_name').val();
        var examen_price = $('#modal_examen_price').val();
        var nombre = $('#modal_nombre').val();
        var edad = $('#modal_edad').val();
        var genero = $('#modal_genero').val();
        $('#modal_close').click();

        var examen = examen_id + " " + examen_name +
            "<div class='form-group hidden'>" +
            "<input name='exam_id[]' value='" + examen_id + "'>" +
            "<input name='paciente_nombre[]' value='" + nombre + "'>" +
            "<input name='paciente_edad[]' value='" + edad + "'>" +
            "<input name='paciente_genero[]' value='" + genero + "'>" +
            "</div>";

        var paciente = nombre + " " + edad + " " + genero;

        var del = "<div class='btn btn-danger delete'><i class='fa fa-times'></i> </div>";

        t.row.add(['', examen, paciente, examen_price, del]).draw();

        event.preventDefault();
    });

    $('#factura_body').on('click', 'div.delete', function () {
        t
            .row($(this).parents('tr'))
            .remove()
            .draw();
    });

    $('#submit').click(function () {
        $('#form').submit();
    });

});
