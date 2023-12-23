<?php

namespace Controllers;

use Model\Cita;
use Model\Servicio;


class APIController {
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar () {
        
        $cita = new Cita($_POST);
        $respuesta = $cita->guardar();
        echo json_encode($respuesta);
    }
}