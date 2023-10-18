<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\CitaController;
use MVC\Router;

$router = new Router();

$router->get("/",[LoginController::class,"login"]);
$router->post("/",[LoginController::class,"login"]);

$router->get('/salir',[LoginController::class,'salir']);
$router->get("/olvide",[LoginController::class,"olvide"]);
$router->post("/olvide",[LoginController::class,"olvide"]);
$router->get("/recuperar",[LoginController::class,"recuperar"]);
$router->post("/recuperar",[LoginController::class,"recuperar"]);
$router->get("/registro",[LoginController::class,"registro"]);
$router->post("/registro",[LoginController::class,"registro"]);
$router->get("/confirmar",[LoginController::class,"confirmar"]);
$router->get("/mensaje",[LoginController::class,"mensaje"]);

$router->get("/hola",[LoginController::class,"hola"]);



$router->get("/admin",[CitaController::class,"admin"]);
$router->post("/admin",[CitaController::class,"admin"]);
$router->post("/cita",[CitaController::class,"cita"]);
$router->get("/cita",[CitaController::class,"cita"]);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
