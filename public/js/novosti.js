//Ovaj dio se bavi CK-editorom
document.getElementsByClassName("ck")[0].classList.add("editor");

//Ovaj dio radi s preview-om
document.getElementById("show-heading").addEventListener("click", open_title);
document.getElementById("show-article").addEventListener("click", open_article);

function open_article() {
    console.log("otvoren article");
}

function open_title() {
    console.log("otvoren naslov");
}

//Ovaj dio radi s prikazom slike
let addImage =  function() {
	let image = document.getElementById('output');
    document.getElementById('image-parent').classList.remove('d-none');
	image.src = URL.createObjectURL(img_field.files[0]);
};

let img_field = document.getElementById('img_path');
img_field.addEventListener('change', addImage);


