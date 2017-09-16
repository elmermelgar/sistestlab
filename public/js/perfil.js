function delExam(exam_id, exam_display_name) {
    $("#del_exam_id").val(exam_id);
    $("#exam_display_name").html(exam_display_name);
}

$(document).ready(function () {

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
        return repo.display_name || repo.text;
    }

    $("#exam_id").select2({
        placeholder: 'Seleccione un examen',
        ajax: {
//                    url: "https://api.github.com/search/repositories",
            url: "/search/exam",
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
        templateResult: formatRepoExam,
        templateSelection: formatRepoSelectionExam
    });
});
