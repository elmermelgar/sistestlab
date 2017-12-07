$(document).ready(function () {
    $('#factura').dataTable({
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

    $('#nivel').slider({
        formatter: function (value) {
            return Math.round(value * 100) + '%';
        }
    });

    var total = parseFloat($('#facturar_total').val());

    function suma() {
        var monto = parseFloat($('#facturar_monto').val());
        isNaN(monto) ? monto = 0 : null;
        var deuda = (total - monto).toFixed(2);
        $('#facturar_deuda').val(deuda);
        if (deuda > 0) {
            $('#facturar_deuda').css('color', 'red');
        }
        else {
            $('#facturar_deuda').css('color', 'green');
        }
    }

    $('#facturar_monto').bind('input', function () {
        suma();
    });

    var deuda = parseFloat($('#deuda').val());

    function suma_pago() {
        var monto = parseFloat($('#amount').val());
        isNaN(monto) ? monto = 0 : null;
        var nueva_deuda = (deuda - monto).toFixed(2);
        $('#deuda').val(nueva_deuda);
        if (nueva_deuda > 0) {
            $('#deuda').css('color', 'red');
        }
        else {
            $('#deuda').css('color', 'green');
        }
    }

    $('#amount').bind('input', function () {
        suma_pago();
    });

    var credito_fiscal = $('#credito_fiscal');
    var numero_factura = $('#numero');

    if (credito_fiscal[0]) {
        function creditoFiscalClick() {
            if (credito_fiscal[0].checked) {
                numero_factura.removeAttr('required');
                numero_factura.attr('disabled', 'disabled');
            }
            else {
                numero_factura.removeAttr('disabled');
                numero_factura.attr('required', 'required');
            }
        }

        creditoFiscalClick();
        credito_fiscal.change(function () {
            creditoFiscalClick();
        });
    }

});

function Anular(id) {
    var anular_modal = $('#annulModal');
    var anular_factura_id = document.getElementById('anular_factura_id');
    anular_factura_id.value = id;
    anular_modal.modal('show');
}