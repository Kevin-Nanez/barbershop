<h1 class="nombre-pagina">Reestablecer contraseña</h1>
<p class="descripcion-pagina">Ingresa tu nueva contraseña.</p>

<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>

<?php if($error){ return;} ?>
<form class="formulario" method="POST">

    <div class="campo">
        <label for="user_password">Password</label>
        <input type="password" id="user_password" placeholder="Tu Contraseña" name="user_password" />
    </div>

    <div class="campo">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" placeholder="Tu Contraseña" name="confirm_password" />
    </div>
    

    <div class="contenedor-boton">
       <input type="submit" class="boton" value="Restablecer contraseña"/> 
    </div>
    
</form>

<div class="acciones">
    <a href="/">Iniciar Sesión</a>
    <a href="/registro">Registrarse</a>
</div>