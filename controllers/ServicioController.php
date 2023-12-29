<?php 

namespace Controllers;

use MVC\Router;

class ServicioController {
    public static function index(Router $router) {

        iniciarSession();

       $router->render('servicios/index', [
            'nombre'=> $_SESSION['nombre']

       ]);
    }

    public static function crear(Router $router) {

        iniciarSession();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
                
        }

        $router->render('servicios/crear', [
            'nombre'=> $_SESSION['nombre']

       ]);

        
    }

    public static function actualizar(Router $router) {



       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

        $router->render('servicios/actualizar', [
            'nombre'=> $_SESSION['nombre']

       ]);
    }
} 