window.addEventListener("DOMContentLoaded", function() {
    let btnsidevar = document.getElementById("btnsidevar");
    let sidebar = document.getElementById("side_nav");

    let click = true;

    // Botón sidebar
    btnsidevar.addEventListener("click", function(e) {
        e.preventDefault();

        if (click) {
            sidebar.classList.add("ocultar");
            sidebar.classList.add("ocultar-movil");
            click = false;
        } else {
            sidebar.classList.remove("ocultar");
            sidebar.classList.remove("ocultar-movil");
            click = true;
        }
    });

    // MODAL
    let eliminaModal = document.getElementById('eliminaModal');

    eliminaModal.addEventListener('shown.bs.modal', function(event) {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');
        let modalFooter = eliminaModal.querySelector('.modal-footer');
        let input = modalFooter.querySelector('#id');
        input.value = id;
    });

    let cambiarrol = document.getElementById('cambiarrol');
    cambiarrol.addEventListener('show.bs.modal', function(event) {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');
        let modalBody = cambiarrol.querySelector('.modal-body');
        let input = modalBody.querySelector('#id');
        input.value = id;
    });

    // Botón para recargar la página
    document.getElementById('reloadButton').addEventListener('click', function() {
        location.reload(); // Recarga la página completa
    });
});
