<h1 class="nombre-paguina">Login</h1>

<p class="descripcion-paguina">Inicia sesión con tus datos</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formualrio" action="/" method="POST">

    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            placeholder="Tu Email"  
            name="email"
            
        />         
    </div>

    <div class="campo">
        <label for="password">Passeord</label>
        <input 
            type="password"
            id="password"
            placeholder="Tu Password"
            name="password"
        />
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una </a>
    <a href="/olvide">¿Olvidades tu password?</a>
</div>