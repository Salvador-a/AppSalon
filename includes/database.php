<?php

// Establece la conexión a la base de datos utilizando las variables de entorno
$db = mysqli_connect(
    $_ENV['DB_HOST'],  // Dirección del host de la base de datos
    $_ENV['DB_USER'],  // Nombre de usuario para acceder a la base de datos
    $_ENV['DB_PASS'],  // Contraseña para acceder a la base de datos
    $_ENV['DB_NAME']   // Nombre de la base de datos
);

// Configura el conjunto de caracteres de la conexión a utf8
$db->set_charset('utf8');

// Verifica si la conexión fue exitosa
if (!$db) {
    // Si hay un error, muestra un mensaje de error y detalles adicionales para depuración
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();  // Muestra el número de error
    echo "error de depuración: " . mysqli_connect_error();  // Muestra el mensaje de error
    exit;  // Sale del script si la conexión falla
}
