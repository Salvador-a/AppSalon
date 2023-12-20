<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;



class LoginController {
    
    public static function login(Router $router) {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                // Comprobar que exites usuraio
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario) {
                    // Verificar Usuario
                    if( $usuario->comprobarPasswordAndVerificado($auth->password) ) {
                        // Autentificar el usurio
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento

                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        }else {
                            header('Location: /cita');
                        }
                        
                    }
                }else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout() {
        echo "Hola desde logout";
    }

    public static function olvide(Router $router) {

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email); 

                if($usuario && $usuario->confirmado === "1") {
                    // Generar un token de uso
                    $usuario->crearToken();
                    $usuario->guardar();

                    // Enaviar el emial
                    
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    
                    // Alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu email');

                    
                } else {
                    Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                    
                }
                
            }
        }
        $alertas = Usuario::getAlertas();
        
        // Es la rutas del archivo de donde va tener los etilos
        $router ->render('auth/olvide-password', [
            'alertas' => $alertas

        ]);
    }

    public static function recuperar(Router $router) {
        
        $router->render('auth/recuperar-password', [

        ]);
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