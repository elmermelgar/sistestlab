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
            "zeroRecords": "Sin exámenes"
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
        $('#modal_profile_name').val(repo.name);
        $('#modal_profile_display_name').val(repo.display_name);
        $('#modal_profile_price').val(repo.price);
        return repo.display_name || repo.text;
    }

    function formatRepoPaciente(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

        markup += "<div class='select2-result-repository__description'>";
        (repo.dui !== '') ? markup += "DUI: " + repo.dui + " " : null;
        markup += "Sexo: " + repo.sexo + "</div>";

        return markup;
    }

    function formatRepoSelectionPaciente(repo) {
        $('#modal_nombre').val(repo.full_name);
        $('#modal_edad').val(repo.edad);
        $('#modal_sexo').val(repo.sexo);
        return repo.full_name || repo.text;
    }

    $("#cliente_id").select2({
        placeholder: 'Seleccione un cliente',
        ajax: {
//                    url: "https://api.github.com/search/repositories",
            url: "/search/customer",
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

    $("#modal_profile_id").select2({
        placeholder: 'Seleccione un examen o perfil',
        ajax: {
//                    url: "https://api.github.com/search/repositories",
            url: "/search/profile",
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


    $("#modal_paciente_id").select2({
        placeholder: 'Seleccione un paciente',
        ajax: {
//                    url: "https://api.github.com/search/repositories",
            url: "/search/paciente",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    full_name: params.term, // search term
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
        templateResult: formatRepoPaciente,
        templateSelection: formatRepoSelectionPaciente
    });

    $("#modal_form").submit(function (event) {
        var profile_id = $('#modal_profile_id').val();
        var profile_name = $('#modal_profile_name').val();
        var profile_display_name = $('#modal_profile_display_name').val();
        var profile_price = $('#modal_profile_price').val();
        var paciente_id = $('#modal_paciente_id').val();
        var numero_boleta = $('#modal_numero_boleta').val();
        var nombre = $('#modal_nombre').val();
        var edad = $('#modal_edad').val();
        var sexo = $('#modal_sexo').val();
        $('#modal_close').click();

        var profile = profile_name + " " + profile_display_name +
            "<div class='form-group hidden'>" +
            "<input name='invoice_profile_id[]' value='0'>" +
            "<input name='profile_id[]' value='" + profile_id + "'>" +
            "<input name='numero_boleta[]' value='" + numero_boleta + "'>" +
            "<input name='paciente_nombre[]' value='" + nombre + "'>" +
            "<input name='paciente_edad[]' value='" + edad + "'>" +
            "<input name='paciente_sexo[]' value='" + sexo + "'>";
        if (paciente_id) {
            profile += "<input name='paciente_id[]' value='" + paciente_id + "'>" + "</div>";
        }
        else {
            profile += "<input name='paciente_id[]'>" + "</div>";
        }

        var paciente = nombre + " " + edad + " " + sexo + " Boleta: " + numero_boleta;

        var del = "<div class='btn btn-danger delete'><i class='fa fa-times'></i> </div>";

        t.row.add(['', profile, paciente, profile_price, del]).draw();

        event.preventDefault();
    });

    if ($("#modal_sexo").is('select')) {
        $("#modal_sexo").select2({
            placeholder: "Seleccione sexo",
            minimumResultsForSearch: Infinity
        });
    }

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
