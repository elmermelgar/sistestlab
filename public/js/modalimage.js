// Get the modal
var modal = document.getElementById('imgModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var modalImg = document.getElementById("img");
var captionText = document.getElementById("caption");
function imgModal(file_name,description){
    modal.style.display = "block";
    modalImg.src = 'storage/images/'+file_name;
    captionText.innerHTML = description;
}

// Get the modal
var modalDel = document.getElementById('imgModalDel');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var modalImgDel = document.getElementById("imgDel");
var captionTextDel = document.getElementById("captionDel");
var idInput = document.getElementById("id");
function imgModalDel(id,file_name,title){
    modalDel.style.display = "block";
    modalImgDel.src = 'storage/images/'+file_name;
    idInput.value=id;
    captionTextDel.innerHTML = title;
}

