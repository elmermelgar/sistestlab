$(document).ready(function () {

    var origen = $('#origin_center');
    var paciente = $('#patient');
    var user = $('#user');
    var natural = $('#natural_person');
    var juridica = $('#juridical_person');
    var dui = $('#identity_document');
    var nit = $('#nit');
    var nrc = $('#nrc');
    var giro = $('#business');
    var div_paciente = $('#div_paciente');
    var div_avatar = $('#crop-avatar');
    var div_juridica = $('#div_juridica');
    var div_natural = $('#div_natural');
    var nombre_label = $('#first_name_label');
    var nombre = $('#first_name');
    var apellido = $('#last_name');
    var sexo = $('#sex');
    var fecha_nacimiento = $('#birth_date');

    moment.locale('es');
    Inputmask().mask(document.querySelectorAll("input"));

    fecha_nacimiento.daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        startDate: fecha_nacimiento.val() || new Date(),
        singleDatePicker: true,
        showDropdowns: true
    });

    function origenClick() {
        if (origen[0].checked) {
            natural.attr('disabled', 'disabled');
            juridica.attr('disabled', 'disabled');
            juridica[0].checked = true;
        }
        else {
            natural.removeAttr('disabled');
            juridica.removeAttr('disabled');
        }
        juridicaClick();
    }

    origenClick();
    origen.change(function () {
        origenClick();
    });

    function pacienteClick() {
        if (paciente[0].checked) {
            div_paciente.removeClass('hidden');
            sexo.removeAttr('disabled');
            fecha_nacimiento.removeAttr('disabled');
            sexo.attr('required', 'required');
            fecha_nacimiento.attr('required', 'required');
        }
        else {
            div_paciente.addClass('hidden');
            sexo.attr('disabled', 'disabled');
            fecha_nacimiento.attr('disabled', 'disabled');
            sexo.removeAttr('required');
            fecha_nacimiento.removeAttr('required');
        }
    }

    pacienteClick();
    paciente.change(function () {
        pacienteClick();
    });

    function juridicaClick() {
        if (juridica[0].checked) {
            nombre_label.html('Razón Social');
            nombre.attr('placeholder', 'Razón Social');
            apellido.attr('disabled', 'disabled');
            apellido.attr('disabled', 'disabled');
            apellido.removeAttr('required');
            dui.removeAttr('required');
            nit.attr('required', 'required');
            nrc.attr('required', 'required');
            giro.attr('required', 'required');
            div_natural.addClass('hidden');
            div_juridica.removeClass('hidden');
            paciente.attr('disabled', 'disabled');
            paciente[0].checked = false;
        }
        else {
            nombre_label.html('Nombre');
            nombre.attr('placeholder', 'Nombre');
            apellido.removeAttr('disabled');
            apellido.attr('required', 'required');
            dui.attr('required', 'required');
            nit.removeAttr('required');
            nrc.removeAttr('required');
            giro.removeAttr('required');
            div_natural.removeClass('hidden');
            div_juridica.addClass('hidden');
            paciente.removeAttr('disabled');
        }
    }

    natural.change(function () {
        juridicaClick();
    });
    juridica.change(function () {
        juridicaClick();
    });
    juridicaClick();

});
