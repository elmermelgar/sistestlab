
$(document).ready(function(){
    $("#avatar").change(previewAvatar);
});

function uploadAvatar() {
    foto = $('#avatar').val();
    if (foto) {
        $('#labelAvatar').button('loading');
        var data = new FormData($("#formAvatar")[0]);
        $.ajax({
            url: document.URL+'/changeAvatar',
            type: 'POST',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus) {
                $('#foto').attr('src', data+'?'+new Date().getTime());
                $('#labelAvatar').button('reset');
                alertify.success('La foto se subió exitosamente');
            },
            error: function (data, textStatus) {
                $('#labelAvatar').button('reset');
                alertify.error(textStatus+': la foto no se ha subido');
                console.log(data.statusText);
            }
        });

    }
}

function previewAvatar(evt) {
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
                $('.avatar-view').attr('src', e.target.result);
            };
        })(f);
        reader.readAsDataURL(f);
    }
}
