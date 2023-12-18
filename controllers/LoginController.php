<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController {
    
    public static function login(Router $router) {
        
        $router->render('auth/login');
    }

    public static function logout() {
        echo "Hola desde logout";
    }

    public static function olvide(Router $router) {
        
        // Es la rutas del archivo de donde va tener los etilos
        $router ->render('auth/olvide-password', [

        ]);
    }

    public static function recuperar() {
        echo "Hola desde recuperar";
    }

    public static function crear(Router $router) {
        
        //instanciar ususrio
        $usuario = new Usuario($_POST);

        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            debuguear($alertas);
            
        }
        
        $router ->render('auth/crear-cuenta', [
            'usuario' => $usuario

        ]);
    }
}