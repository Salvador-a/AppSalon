<?php

namespace Controllers;


use MVC\Router;

class AdminControllers {
    public static function index( Router $router ) {
        iniciarSession();
        
        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre']
        ]);
    }
}