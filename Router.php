<?php

namespace MVC;

class Router
{
    // Arrays para almacenar rutas GET y POST
    public array $getRoutes = [];
    public array $postRoutes = [];

    // Método para agregar rutas GET
    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    // Método para agregar rutas POST
    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    // Método principal para comprobar y manejar las rutas
    public function comprobarRutas()
    {
        // Proteger Rutas...
        session_start();

        // Arreglo de rutas protegidas...
        // $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

        // $auth = $_SESSION['login'] ?? null;

        // Obtener la URL y el método de la solicitud actual
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        // Determinar la función asociada según el método (GET o POST) y la URL
        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        // Ejecutar la función asociada si se encuentra
        if ($fn) {
            // Call user func va a llamar una función cuando no sabemos cuál será
            call_user_func($fn, $this); // El objeto Router se pasa como argumento
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }

    // Método para renderizar vistas
    public function render($view, $datos = [])
    {
        // Leer lo que le pasamos a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dólar significa: variable variable
                            // Básicamente, nuestra variable sigue siendo la original,
                            // pero al asignarla a otra no la reescribe, mantiene su valor.
                            // De esta forma, el nombre de la variable se asigna dinámicamente.
        }

        // Almacenamiento en memoria durante un momento...
        ob_start();

        // Incluimos la vista en el layout
        include_once __DIR__ . "/views/$view.php";
        // Limpia el buffer
        $contenido = ob_get_clean();

        // Incluimos el layout
        include_once __DIR__ . '/views/layout.php';
    }
}
