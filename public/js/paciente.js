$(document).ready(function () {

    /* Sam Deering function; bjverde improvements
    * https://www.sitepoint.com/url-parameters-jquery
    */
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results ? results[1] || 0 : null;
    };

    moment.locale('es');

    var customer = $('#customer_id');
    customer.SumoSelect({
        search: true,
        placeholder: 'Seleccione el cliente a asociar',
        okCancelInMulti: true
    });

    var birth_date = $('#birth_date');
    birth_date.daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        startDate: birth_date.val() || new Date(),
        singleDatePicker: true,
        showDropdowns: true
    });

    Inputmask().mask(document.querySelectorAll("input"));

    customer[0].sumo.selectItem($.urlParam('cliente'));
});