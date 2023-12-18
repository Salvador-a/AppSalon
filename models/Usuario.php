<?php

namespace Model;

class Usuario extends ActiveRecord {
    // base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefon', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    // Cambio en la definición de la propiedad
    protected static $alertas = [];

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apllido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? null;
        $this->confirmado = $args['confirmado'] ?? null;
        $this->token = $args['token'] ?? '';
    }

    // Mensajes de validacion para la creación de una cuenta

    public function validarNuevaCuenta() {
        
        if (!$this->nombre) {
            // Cambio en el acceso a la propiedad
            self::$alertas['error'][] = 'El nombre del Cliente es obligatorio';
        }

        if (!$this->apellido) {
            // Cambio en el acceso a la propiedad
            self::$alertas['error'][] = 'El apellido del Cliente es obligatorio';
        }

        // Cambio en el retorno
        return self::$alertas;
    }
}
