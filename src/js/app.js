let paso = 1;

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); // Muestra y Oculta las seciones   
    tabs(); // Cambia la sección cuando se presionen los tabs
    botonesPaginador(); // Agrega o quita los botones del paginador
}
function mostrarSeccion() {

    // Ocutal la sección 1ue tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar')        
    }
    
    // Seleccionar la sección con el paso..
    const pasoSelector =  `#paso-${paso}`
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    // Quitar la clase de actual al atba anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

};

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(  boton => {
        boton.addEventListener('click', function(e) {
            paso = parseInt (e.target.dataset.paso);

            mostrarSeccion();

            botonesPaginador();

        });
    })
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

}