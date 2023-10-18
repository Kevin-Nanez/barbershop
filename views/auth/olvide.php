<h1 class="nombre-pagina">Reestablecer contraseña</h1>
<p class="descripcion-pagina">Ingresa tu E-mail para restasblecer tu contraseña.</p>

<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="post" action="/olvide">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email" />
    </div>

    <div class="contenedor-boton">
       <input type="submit" class="boton" value="Reestablecer Contraseña"/> 
    </div>
    

</form>

<div class="acciones">
    <a href="/">Iniciar Sesion</a>
    <a href="/registro">Registrarse</a>
</div>