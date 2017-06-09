$(document).ready(function () {

    var t = $('#factura').DataTable({
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

    $("#recolector_id").select2({
        placeholder: "Seleccione un recolector",
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

    function formatRepoProfile(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.display_name + "</div>";

        markup += "<div class='select2-result-repository__description'>";
        repo.type === 0 ? markup += "Examen " : markup += "Grupo ";
        markup += "$" + repo.price + "</div>";

        return markup;
    }

    function formatRepoSelectionProfile(repo) {
        $('#modal_profile_name').val(repo.display_name);
        $('#modal_profile_price').val(repo.price);
        return repo.display_name || repo.text;
    }

    $("#cliente_id").select2({
        placeholder: 'Seleccione un cliente',
        ajax: {
//                    url: "https://api.github.com/search/repositories",
            url: "/facturas/search/customer",
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
        minimumInputLength: 3,
        language: {
            inputTooShort: function () {
                return "Escriba 3 o más caracteres para buscar";
            },
            searching: function () {
                return "Buscando...";
            },
            noResults: function () {
                return "Sin resultados";
            }
        },

        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });
    $("#modal_genero").select2({
        placeholder: "Seleccione género",
        minimumResultsForSearch: Infinity
    });
    $("#modal_profile_id").select2({
        placeholder: 'Seleccione un examen o perfil',
        ajax: {
//                    url: "https://api.github.com/search/repositories",
            url: "/facturas/search/profile",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    display_name: params.term, // search term
                    sucursal_id: $("#sucursal_id").val(),
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
        minimumInputLength: 2,
        language: {
            inputTooShort: function () {
                return "Escriba 2 o más caracteres para buscar";
            },
            searching: function () {
                return "Buscando...";
            },
            noResults: function () {
                return "Sin resultados";
            }
        },
        templateResult: formatRepoProfile,
        templateSelection: formatRepoSelectionProfile
    });

    $("#modal_form").submit(function (event) {
        var profile_id = $('#modal_profile_id').val();
        var profile_name = $('#modal_profile_name').val();
        var profile_price = $('#modal_profile_price').val();
        var numero_boleta = $('#modal_numero_boleta').val();
        var nombre = $('#modal_nombre').val();
        var edad = $('#modal_edad').val();
        var genero = $('#modal_genero').val();
        $('#modal_close').click();

        var profile = profile_id + " " + profile_name +
            "<div class='form-group hidden'>" +
            "<input name='profile_id[]' value='" + profile_id + "'>" +
            "<input name='numero_boleta[]' value='" + numero_boleta + "'>" +
            "<input name='paciente_nombre[]' value='" + nombre + "'>" +
            "<input name='paciente_edad[]' value='" + edad + "'>" +
            "<input name='paciente_genero[]' value='" + genero + "'>" +
            "</div>";

        var paciente = nombre + " " + edad + " " + genero + " boleta: " + numero_boleta;

        var del = "<div class='btn btn-danger delete'><i class='fa fa-times'></i> </div>";

        t.row.add(['', profile, paciente, profile_price, del]).draw();

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
