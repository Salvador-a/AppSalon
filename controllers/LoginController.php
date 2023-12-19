<?php

namespace Controllers;

use Classes\Email;
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

        // Alertas vacias
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Rivisar que alertas este vacio
             // Revisar que alerta este vacio
             if(empty($alertas)) {
                // Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
              } else {
                    // Hashear el Password
                    $usuario->hashPassword();

                    // Generar un token único 
                    $usuario->crearToken();

                    // Enviar el Emaiul
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                   $email->enviarConfirmacion();

                   // Crear el usuario
                $resultado = $usuario->guardar();
                // debuguear($usuario);
                if($resultado) {
                    header('Location: /mensaje');
                }

                    
                    
              }
            }
        
        }
        
        $router ->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas,
            

        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    } 

    public static function confirmar(Router $router) {

        $alertas = [];

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token No Válido');
        } else {
            // Modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = '';
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }
        // Obtener laerta
         $alertas = Usuario::getAlertas();

         // Renderizar la vista
         $router->render('auth/confirmar-cuenta' , [
                'alertas' => $alertas
         ]);

    }
}