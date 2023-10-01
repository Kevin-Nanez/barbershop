<?php

namespace Controllers;

use Clases\email;
use Model\usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        $router -> render('auth/login');
    }
    public static function registro(Router $router){
        $usuario = new usuario($_POST);

        $alertas=[];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){            
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarRegistro();

            //revisar que alertas esté vacío
            if(empty($alertas)){
            //comprobar que no exista el email ni el correo en la bd
                $alertas= $usuario->existeUsuario();
                if(empty($alertas)){
                    //insertar usuario en la db
                    //hashear password
                    $usuario->hashPassword();
                    // ver si hay otro usuario con la contraseña
                    //$alertas= $usuario->samePassword();
                    if (empty($alertas)){
                        //generar token para el registro
                        $usuario->crearToken();
                        //enviar email
                        $email = new email($usuario->email,$usuario->nombre,$usuario->token); 

                        $email->enviarToken();

                        //crear usuario
                        $resultado = $usuario->guardar();
                        if($resultado){
                            //header('Location: \mensaje');
                        }

                    }

                }
            }
        }
        $router -> render('auth/registro',[
            //pasarle el objeto usuario al php que va a renderizar
            'usuario' =>$usuario,
            'alertas' =>$alertas
        ]);
    }
    
    public static function salir(){
        echo "salir" . "<br>";
    }

    public static function olvide(Router $router){
        $router -> render('auth/olvide', [
            
        ]);
    }

    public static function recuperar(Router $router){
        echo "recuperar" . "<br>";
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
        $alertas = [];

        $token = s($_GET['token']);
        
        $usuario = usuario::where('token',$token);

        if(empty($usuario)){
        // mostrar error
            usuario::setAlerta('error','Token no valido');

        }else{
            // modificar usuario confirmado
            usuario::setAlerta('success','Usuario confirmado correctamente');
            $usuario -> confirmado = "1";
            $usuario -> token = NULL;
            $usuario ->guardar(); 
        }

        $alertas = usuario::getAlertas(); 
        $router->render('auth/confirmar',[
            'alertas' => $alertas
        ]);
    }

}