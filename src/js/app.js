let paso = 1;

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
   
    tabs(); // Cambia la sección cuando se presionen los tabs
}
function mostrarSeccion() {
    console.log('Mostrar seccion..')
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