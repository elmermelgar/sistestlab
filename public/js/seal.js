
$(document).ready(function(){
    $("#seal").change(previewSeal);
});

function uploadSeal() {
    foto = $('#seal').val();
    if (foto) {
        $('#labelSeal').button('loading');
        var data = new FormData($("#formSeal")[0]);
        $.ajax({
            url: document.URL+'/changeSeal',
            type: 'POST',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus) {
                $('#foto').attr('src', data+'?'+new Date().getTime());
                $('#labelSeal').button('reset');
                alertify.success('La foto se subió exitosamente');
            },
            error: function (data, textStatus) {
                $('#labelSeal').button('reset');
                alertify.error(textStatus+': la foto no se ha subido');
                console.log(data.statusText);
            }
        });

    }
}

function previewSeal(evt) {
    var files = evt.target.files; // FileList object

    // Obtenemos la imagen del campo "file".
    for (var i = 0, f; f = files[i]; i++) {
        //Solo admitimos imágenes.
        if (!f.type.match('image.*')) {
            continue;
        }
        var reader = new FileReader();
        reader.onload = (function(theFile) {
            return function(e) {
                $('#faimage').hide();
                $('.seal-view').attr('src', e.target.result);
            };
        })(f);
        reader.readAsDataURL(f);
    }
}
