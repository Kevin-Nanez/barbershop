<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Selecciona los servicios y rellena los campos</p>

<?php
include_once __DIR__ . "/../templates/alertas.php";
?>

<div class="app">
    <div id="paso-1" class="seccion">
        <h2 class="text-center">Servicios</h2>
        <p class="text-center">Elige los servicios que deseas</p>
    </div>

    <div id="paso-2" class="seccion">
        <h2 class="text-center">Cita</h2>
        <p class="text-center">Rellena los campos con tu información y programa la cita</p>


        <form class="formulario" method="POST" action="/registro">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input disabled type="text" id="nombre" placeholder="Tu nombre" name="nombre" value="<?php echo s($nombre);?>" />
            </div>

    <div class=" campo">
                <label for="phone">Telefono</label>
                <input type="tel" id="phone" placeholder="Tu telefono" name="phone" value="<?php echo s($_SESSION['phone']);?>" />
            </div>


            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" />
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora" name="hora" />
            </div>

            <div class="contenedor-boton">
                <input type="submit" class="boton" value="Agendar Cita" />
            </div>

        </form>


    </div>

    <div id="paso-3" class="seccion">
        <h2 class="text-center">Resumen</h2>
        <p class="text-center">Verifica que la información coincida</p>
    </div>





</div>