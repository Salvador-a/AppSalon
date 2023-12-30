<?php 

// Incluye la clase ActiveRecord
use Model\ActiveRecord;

// Requiere el archivo autoload.php de Composer para cargar las dependencias
require __DIR__ . '/../vendor/autoload.php';

// Crea una instancia de Dotenv para cargar las variables de entorno desde el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad(); // Carga de manera segura las variables de entorno

// Requiere los archivos de funciones y de configuración de base de datos
require 'funciones.php';
require 'database.php';

// Conecta la base de datos a través de la clase ActiveRecord
ActiveRecord::setDB($db);
