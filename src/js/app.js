let paso = 1;

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
   
    tabs(); // Cambia la sección cuando se presionen los tabs
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

};

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(  boton => {
        boton.addEventListener('click', function(e) {
            paso = parseInt (e.target.dataset.paso);

            mostrarSeccion();

        });
    })
}