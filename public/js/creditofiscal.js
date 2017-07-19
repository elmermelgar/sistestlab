$(document).ready(function () {

    var table = $('#facturas').bootstrapTable();

    // Handle form submission event
    $('#credito_fiscal_form').on('submit', function (e) {
        $('input[name^="factura_id"]').remove();
        var form = this;
        var rows_selected = table.bootstrapTable('getSelections');
        // Iterate over all selected checkboxes
        $.each(rows_selected, function (index, value) {
            console.log(index, value);
            // Create a hidden element
            $(form).append(
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'factura_id[]')
                    .val(value.id)
            );
        });
    });

});

function checkTaxCredits(ids) {
    for (var k in ids) {
        if (ids.hasOwnProperty(k)) {
            ids[k] = String(ids[k]);
        }
    }
    $('#facturas').bootstrapTable('checkBy', {field: 'id', values: ids});
}
