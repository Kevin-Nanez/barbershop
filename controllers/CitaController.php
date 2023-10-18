<?php

    namespace Controllers;

    use MVC\Router;

    class CitaController{

        public static function cita(Router $router){
            session_start();
            
            $router->render('cita/cita',[
                'nombre' => $_SESSION['nombre']
            ] );

        }

        public static function admin(Router $router){
            session_start();
            
            $router->render('cita/admin',[
                'nombre'=> $_SESSION['nombre']
            ]);

        }

    }


?>