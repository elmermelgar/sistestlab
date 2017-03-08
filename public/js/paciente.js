
$(document).ready(function () {

    var paciente=$('#paciente');
    var div_nombre=$('#div_nombre');
    var div_apellido=$('#div_apellido');
    var div_genero=$('#div_genero');
    var div_fecha_nacimiento=$('#div_fecha_nacimiento');
    var nombre=$('#nombre');
    var apellido=$('#apellido');
    var genero=$('#genero');
    var fecha_nacimiento=$('#fecha_nacimiento');

    fecha_nacimiento.daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
    });

    function pacienteClick() {
        if(paciente[0].checked){
            div_nombre.removeClass('hidden');
            div_apellido.removeClass('hidden');
            div_genero.removeClass('hidden');
            div_fecha_nacimiento.removeClass('hidden');
            nombre.removeAttr('disabled');
            apellido.removeAttr('disabled');
            genero.removeAttr('disabled');
            fecha_nacimiento.removeAttr('disabled');
        }
        else{
            div_nombre.addClass('hidden');
            div_apellido.addClass('hidden');
            div_genero.addClass('hidden');
            div_fecha_nacimiento.addClass('hidden');
            nombre.attr('disabled','disabled');
            apellido.attr('disabled','disabled');
            genero.attr('disabled','disabled');
            fecha_nacimiento.attr('disabled','disabled');
        }
    }
    pacienteClick();
    paciente.change(function () {
        pacienteClick();
    });

});
