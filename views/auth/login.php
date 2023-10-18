<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Ingresa tus datos para iniciar sesión</p>

<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="post" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email" />
    </div>
    <div class="campo">
        <label for="user_password">Password</label>
        <input type="password" id="user_password" placeholder="Tu Contraseña" name="user_password" />
    </div>
    

    <div class="contenedor-boton">
       <input type="submit" class="boton" value="Iniciar sesión"/> 
    </div>
    

</form>

<div class="acciones">
    <a href="/registro">Registrarse</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>