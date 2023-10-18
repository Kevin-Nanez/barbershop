<?php

namespace Controllers;

use Clases\email;
use Model\usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                // comprobar si exsite el susario
                $usuario = usuario::where('email', $auth->email);

                if ($usuario) {
                    //verificar password y que esté confirmado
                    $alertas = $usuario->validarPassword($auth->user_password);

                    if (empty($alertas)) {
                        //iniciar sesion
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['phone'] = $usuario->phone;
                        $_SESSION['login'] = true;

                        if ($usuario->administrador === "1") {
                            $_SESSION['administrador'] = $usuario->administrador ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    usuario::setAlerta('error', 'Email Invalido');
                }
            }
        }

        $alertas = usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function registro(Router $router)
    {
        $usuario = new usuario($_POST);

        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarRegistro();

            //revisar que alertas esté vacío
            if (empty($alertas)) {
                //comprobar que no exista el email ni el correo en la bd
                $alertas = $usuario->existeUsuario();
                if (empty($alertas)) {
                    //insertar usuario en la db
                    //hashear password
                    $usuario->hashPassword();
                    // ver si hay otro usuario con la contraseña
                    //$alertas= $usuario->samePassword();
                    if (empty($alertas)) {
                        //generar token para el registro
                        $usuario->crearToken();
                        $usuario->primeraMayuscula();
                        //enviar email
                        $email = new email($usuario->email, $usuario->nombre, $usuario->token);

                        $email->enviarToken();

                        //crear usuario
                        $resultado = $usuario->guardar();
                        if ($resultado) {
                            header('Location: \mensaje');
                        }
                    }
                }
            }
        }
        $router->render('auth/registro', [
            //pasarle el objeto usuario al php que va a renderizar
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function salir()
    {
        echo "salir" . "<br>";
    }

    public static function olvide(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $auth = new usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                // validar si usuario existe
                $usuario = usuario::where('email', $auth->email);
                if ($usuario) {
                    //enviar token de recuperacion
                    $usuario->crearToken();
                    $usuario->guardar();
                    

                    if ($usuario->confirmado === "1") {
                        $email = new email($usuario->email,$usuario->nombre, $usuario->token);

                       $email->emailResetPassword();
                    

                        usuario::setAlerta('success', 'Revisa tu Email para cambiar la contraseña');

                    } else{
                        usuario::setAlerta('error', 'El Email ingresado no ha sido confirmado, verifique la bandeja de entrada de su Email');
                    }
                }else{
                    usuario::setAlerta('error', 'Email Invalido');
                }
            }
        }

        $alertas = usuario::getAlertas();
        $router->render('auth/olvide', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        $alertas=[];
        $token = s($_GET['token']);
        $error= false;
    
        $usuario = usuario::where('token',$token);
    
        if (!empty($usuario)) {

            if ($_SERVER['REQUEST_METHOD'] === "POST"){ 
                 // Crea una instancia de la clase
                $alertas = $usuario->ValidarCambioPassword($_POST['user_password'], $_POST['confirm_password']);
                
                if(empty($alertas)){
                    $usuario->user_password = $_POST['user_password'];
                    $usuario->hashPassword();
                    $usuario->token = null;
                    $usuario->actualizar();
                    header('Location: /');
                }
            } 
        }else{
            usuario::setAlerta('error', 'Token Invalido');
            $error= true;

    }

        $alertas = usuario::getAlertas();
        $router->render('auth/recuperar', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }




    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];

        $token = s($_GET['token']);

        $usuario = usuario::where('token', $token);

        if (empty($usuario)) {
            // mostrar error
            usuario::setAlerta('error', 'Token no valido');
        } else {
            // modificar usuario confirmado
            usuario::setAlerta('success', 'Usuario confirmado correctamente');
            $usuario->confirmado = "1";
            $usuario->token = NULL;
            $usuario->guardar();
        }

        $alertas = usuario::getAlertas();

        $router->render('auth/confirmar', [
            'alertas' => $alertas
        ]);
    }


}
