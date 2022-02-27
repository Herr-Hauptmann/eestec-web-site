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
