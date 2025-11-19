<?php
// Este archivo contiene la configuración y la función para conectar a la base de datos MySQL.
// Se utiliza para no repetir el código de conexión en cada archivo PHP que lo necesite.

$servername = "mysql.inf.uct.cl"; 
$username = "bliempi";           
$password = "Sarastian1205!."; 
$dbname = "A2025_bliempi";    

// Crear la conexión usando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión falló
if ($conn->connect_error) {
    // La función die() detiene la ejecución del script y muestra un mensaje.
    die("Conexión fallida: " . $conn->connect_error);
}

// Opcional: Establecer el conjunto de caracteres a UTF-8 para evitar problemas con tildes y ñ.
$conn->set_charset("utf8");
?>