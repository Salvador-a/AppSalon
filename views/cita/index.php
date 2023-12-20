<h1 class="nombre-paguina">Crear Nueva Cita</h1>
<p class="descripcion-paguina">Eligue tus servicios y coloca tus datos</p>

<div class="app">
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center" >Eligue tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios"></div>

    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center" >Colo tus datos y fecha de tu cita</p>

        <form action="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    id="nombre"
                    type="text"
                    placeholder="Tu Nombre"
                    value="<?php echo $nombre; ?>"
                    disabled
                />
            </div>

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                    id="fecha"
                    type="date"
                />
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                    id="hora"
                    type="time"
                />
            </div>
        </form>

    </div>
    <div id="paso-3" class="seccion">
        <h2>Resumen</h2>
        <p class="text-center" >Verifica que tu informacion sea correcta</p>

    </div>
</div>