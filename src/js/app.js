let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); // Muestra y oculta las secciones
    tabs(); // Cambia la sección cuando se presionen los tabs
    botonesPaginador(); // Agrega o quita los botones del paginador
    paginaSiguiente(); 
    paginaAnterior();

    consultarAPI(); // Consulta la API en en backen de PHP
    nombreCliente(); // Añade el nombre del cliente al objeto de cita
    seleccionarFecha(); // Añade la fecha de la cita en el objeto
    seleccionarHora(); // añade la hora de la cita en el objeto

    mostrarResumen(); // Mustra el resumen de la cita
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

        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}
function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function() {

        if(paso <= pasoInicial) return;
        paso--;
        
        botonesPaginador();
    })
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function() {

        if(paso >= pasoFinal) return;
        paso++;
        
        botonesPaginador();
    })

}

async function consultarAPI() {
    try {
        const url = 'http://localhost:3000/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }

}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        // Desestructuración del objeto servicio para obtener propiedades como id, nombre y precio
        const { id, nombre, precio } = servicio;
    
        // Crear un elemento de párrafo para el nombre del servicio
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;
    
        // Crear un elemento de párrafo para el precio del servicio
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;
    
        // Crear un elemento de contenedor (DIV) para el servicio
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id; // Establecer el atributo de datos con el id del servicio
        servicioDiv.onclick = function() {
            seleccionarServicio(servicio);
        }
    
        // Añadir el elemento del nombre del servicio al contenedor del servicio
        servicioDiv.appendChild(nombreServicio);
    
        // Añadir el elemento del precio del servicio al contenedor del servicio
        servicioDiv.appendChild(precioServicio);
    
         // Agregar el elemento DIV con toda la información al contenedor con ID 'servicios'
        document.querySelector('#servicios').appendChild(servicioDiv);
    
        
    });   
}

function seleccionarServicio(servicio) {
    
    const { id } = servicio;
    const { servicios } = cita;

    // Identificar el elemento que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya fue agregado
    if ( servicios.some( agregado => agregado.id === id) ) {
        //Eliminar
        cita.servicios = servicios.filter( agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    } else {
        // Agregarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
    // console.log(cita);
}

function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e) {
        const dia = new Date(e.target.value).getUTCDay();
        
        if ([6, 0].includes(dia)) {
            e.target.value = '';
            mostrarAlerta('Fines de semana no permitidos', 'error', '.formulario');
        } else {
            cita.fecha = e.target.value;
        }
    });
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e) {
        
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        console.log(hora);

        if (hora < 10 || hora > 18) {
            e.target.value = '';
            mostrarAlerta('Hora No Válida', 'error', '.formulario');
        } else {
            cita.hora = e.target.value;

            // console.log(cita);
        }
    })
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {

    // Previene que se genren más de 1 alerta
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alertaPrevia.remove(); 
    };

    // Scripting para crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);

    referencia.appendChild(alerta);

    if (desaparece) {
        // Eliminar la alerta después de 3s
        setTimeout(() => {
             alerta.remove();   
        }, 3000);
        
    }
}


function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar el Contenido de Resumen
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }
 

   if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Fltan datos de Servicios, Fecha u Hora', 'error', '.contenido-resumen', false);

        return;
   } 
   
   // formater el div de resuen
   const{ nombre, fecha, hora, servicios } =cita;

   

   // Heading para Servicio en resumen
   const HeadingServicios = document.createElement('H3');
   HeadingServicios.textContent = 'Resumen de Servicios';
   resumen.appendChild(HeadingServicios);


   // Iterando y mostrando los servicios
   servicios.forEach(servicio => {
    const { id, precio, nombre, } = servicio;
    const contenedorServicio = document.createElement('DIV');
    contenedorServicio.classList.add('contenedor-servicio');

     const textoServicio = document.createElement('P');
     textoServicio.textContent = nombre;

     const precioServicio = document.createElement('P');
     precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

     contenedorServicio.appendChild(textoServicio);
     contenedorServicio.appendChild(precioServicio);

     resumen.appendChild(contenedorServicio);
   });

   // Heading para Cita en resumen
   const headingCita = document.createElement('H3');
   headingCita.textContent = 'Resumen de Cita';
   resumen.appendChild(headingCita)

   const nombreCliente= document.createElement('P');
   nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

   // Formaterar la fecha en español
   const fechaObj = new Date(fecha);
   const mes = fechaObj.getMonth();
   fechaObj.setDate(fechaObj.getDate() + 2); // Sumar dos días a la fecha

   const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
   const fechaFormateada = fechaObj.toLocaleDateString('es-MX', opciones);
     
   const fechaCita= document.createElement('P');
   fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

   const horaCita= document.createElement('P');
   horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

   // Boton para Crear una Cita
   const botonReservar = document.createElement('BUTTON');
   botonReservar.classList.add('boton');
   botonReservar.textContent = 'Reservar Cita';
   botonReservar.onclick = reservarCita;

   resumen.appendChild(nombreCliente);
   resumen.appendChild(fechaCita);
   resumen.appendChild(horaCita);

   resumen.appendChild(botonReservar);
}

async function reservarCita() {

    const { nombre, fecha, hora, servicios } = cita;

    const idServicio = servicios.map( servicio => servicio.id );
    // console.log(idServicio);

    

    const datos = new FormData();
    datos.append('nombre', nombre);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('servicios', idServicio);

    //   console.log([...datos]);

     

    // Peticion hacia la api
    const url = 'http://localhost:3000/api/citas';

    const respuesta = await fetch(url, {
        method: 'POST',
        body: datos
    });

    const resultado = await respuesta.json();
    console.log(resultado);


   
}