<h1 class="nombre-paguina">Olvidastes Password</h1>
<p class="descripcion-pagina">Reestable tu password escribienod tu email a continuacion</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" action="/olvide" method="POST" >
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            placeholder="Tu Email"  
            name="email"
        />         
    </div>

    <input type="submit" class="boton" value="Enviar Instrucciones">

</form>

<div class="acciones">
    <a href="/">¿Ya tienes uns cuenta? Inicia Sesión </a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una </a>
</div>