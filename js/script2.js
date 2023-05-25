window.addEventListener("DOMContentLoaded",function (){
    let codigo = document.getElementById("numbers");
    codigo.addEventListener("mousedown", function(event) {
        event.preventDefault();
    });
    codigo.addEventListener("copy", function(event) {
        event.preventDefault();
    });
})
