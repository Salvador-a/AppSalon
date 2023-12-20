<h1 class="nombre-paguina">Recuperrar pasword</h1>
<p class="descripcion-paguina">Coloca tu nuevo password a continuación</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<?php if($error) return; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="pssword">Password</label>
            <input 
                type="password"
                id="password"
                name="password"
                placeholder="Tu Nuevo Password"
            />
    </div>
    <input type="submit" class="boton" value="Guadar Nuevo Password">

</form>

<div class="acciones">
    <a href="/">¿Ya tienes uns cuenta? Inicia Sesión </a>
</div>