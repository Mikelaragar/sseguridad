window.addEventListener("DOMContentLoaded",function (){
    let btnsidevar = document.getElementById("btnsidevar");
    let sidebar = document.getElementById("side_nav");


    let click=true;

    //boton sidebar1
    btnsidevar.addEventListener("click",function (e){
        e.preventDefault();

        if (click==true){
            sidebar.classList.add("ocultar");
            sidebar.classList.add("ocultar-movil");
            click=false;
        }
        else {
            sidebar.classList.remove("ocultar");
            sidebar.classList.remove("ocultar-movil");
            console.log("Hola, mundo!");
            click=true;
        }

    })


    //MODAL
    let eliminaModal = document.getElementById('eliminaModal')

     eliminaModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        eliminaModal.querySelector('.modal-footer #id').value = id
    })

    let cambiarpass = document.getElementById('cambiarpass')

    cambiarpass.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        cambiarpass.querySelector('.modal-body #id').value = id
    })
    let cambiarrol = document.getElementById('cambiarrol');
    cambiarrol.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');
        let input = cambiarrol.querySelector('.modal-body #id');
        input.value = id;
    });
    // Botón para recargar la página
    document.getElementById('reloadButton').addEventListener('click', function() {
        location.reload(); // Recarga la página completa
    });

})
