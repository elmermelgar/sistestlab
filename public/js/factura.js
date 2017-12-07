$(document).ready(function () {

    /* Sam Deering function; bjverde improvements
    * https://www.sitepoint.com/url-parameters-jquery
    */
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results ? results[1] || 0 : null;
    };

    moment.locale('es');

    $('#facturas').DataTable({
        "order": [[4, "desc"]],
        "info": false,
        "searching": false,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontró ningún registro",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
    var d = new Date();
    d.setDate(d.getDate()-7);
    $('#fecha_inicio').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        startDate: $.urlParam('fecha_inicio') || d,
        singleDatePicker: true,
        showDropdowns: true
    });
    $('#fecha_fin').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        startDate: $.urlParam('fecha_fin') || new Date(),
        singleDatePicker: true,
        showDropdowns: true
    });
});
