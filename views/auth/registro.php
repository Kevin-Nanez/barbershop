<h1 class="nombre-pagina">Registro</h1>
<p class="descripcion-pagina">Ingresa tus datos para Registrarte</p>

<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/registro">
    <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" placeholder="Tu nombre" name="nombre" value="<?php
            echo s($usuario->nombre);
            ?>" />
    </div>

    <div class="campo">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" placeholder="Tu apellido" name="apellido" value="<?php 
            echo s($usuario->apellido);
            ?>" />
    </div>

    <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Tu Email" name="email" value="<?php 
            echo s($usuario->email);
            ?>" " />
    </div>

    <div class="campo">
            <label for="phone">Telefono</label>
            <input type="tel" id="phone" placeholder="Tu telefono" name="phone" 
            value="<?php 
            echo s($usuario->phone);
            ?>" />
    </div>

    <div class="campo">
        <label for="user_password">Password</label>
        <input type="password" id="user_password" placeholder="Tu Contraseña" name="user_password"/>
    </div>

    <div class="campo">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" placeholder="Tu Contraseña" name="confirm_password" />
    </div>

    <div class="contenedor-boton">
       <input type="submit" class="boton" value="Registrarse"/> 
    </div>

</form>

<div class="acciones">
    <a href="/">Iniciar Sesión</a>
</div>