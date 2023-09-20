<?php

namespace Controllers;

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
                    // ver si hay otro usuario con la contraseña xd
                    $alertas= $usuario->samePassword();
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

    public static function recuperar(){
        echo "recuperar" . "<br>";
    }
}