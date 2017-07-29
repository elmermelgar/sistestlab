$(document).ready(function () {

    var origen = $('#centro_origen');
    var paciente = $('#paciente');
    var user = $('#user');
    var natural = $('#persona_natural');
    var juridica = $('#persona_juridica');
    var dui = $('#dui');
    var nit = $('#nit');
    var nrc = $('#nrc');
    var giro = $('#giro');
    var div_paciente = $('#div_paciente');
    var div_avatar = $('#crop-avatar');
    var div_juridica = $('#div_juridica');
    var div_natural = $('#div_natural');
    var nombre = $('#nombre');
    var apellido = $('#apellido');
    var sexo = $('#sexo');
    var fecha_nacimiento = $('#fecha_nacimiento');

    moment.locale('es');
    Inputmask().mask(document.querySelectorAll("input"));

    fecha_nacimiento.daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        singleDatePicker: true,
        showDropdowns: true
    });

    function origenClick() {
        if (origen[0].checked) {
            natural.attr('disabled', 'disabled');
            juridica.attr('disabled', 'disabled');
            juridica[0].checked = true;
            paciente.attr('disabled', 'disabled');
            paciente[0].checked = false;
        }
        else {
            natural.removeAttr('disabled');
            juridica.removeAttr('disabled');
            paciente.removeAttr('disabled');
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
            nombre.removeAttr('disabled');
            apellido.removeAttr('disabled');
            sexo.removeAttr('disabled');
            fecha_nacimiento.removeAttr('disabled');
            nombre.attr('required', 'required');
            apellido.attr('required', 'required');
            sexo.attr('required', 'required');
            fecha_nacimiento.attr('required', 'required');
        }
        else {
            div_paciente.addClass('hidden');
            nombre.attr('disabled', 'disabled');
            apellido.attr('disabled', 'disabled');
            sexo.attr('disabled', 'disabled');
            fecha_nacimiento.attr('disabled', 'disabled');
            nombre.removeAttr('required');
            apellido.removeAttr('required');
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
            dui.removeAttr('required');
            nit.attr('required', 'required');
            nrc.attr('required', 'required');
            giro.attr('required', 'required');
            div_natural.addClass('hidden');
            div_juridica.removeClass('hidden');
        }
        else {
            dui.attr('required', 'required');
            nit.removeAttr('required');
            nrc.removeAttr('required');
            giro.removeAttr('required');
            div_natural.removeClass('hidden');
            div_juridica.addClass('hidden');
        }
    }

    natural.change(function () {
        juridicaClick();
    });
    juridica.change(function () {
        juridicaClick();
    });
    juridicaClick();

    function userClick() {
        if (user[0].checked) {
            div_avatar.removeClass('hidden');
        }
        else {
            div_avatar.addClass('hidden');
        }
    }

    userClick();
    user.change(function () {
        userClick();
    });

});
