<?php
// Incluimos la conexión que ya funciona
require 'conex.php';

// 2. Definir la consulta para crear la tabla 'speedruns'
$sql_table = "CREATE TABLE IF NOT EXISTS speedruns (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(50) NOT NULL,
    game VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    time_record VARCHAR(20) NOT NULL,
    video_link VARCHAR(255) NOT NULL,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// Ejecutar la consulta
if ($conn->query($sql_table) === TRUE) {
    echo "<h1>¡Éxito!</h1>";
    echo "Tabla 'speedruns' creada o ya existente en la base de datos 'A2025_bliempi'.<br>";
    echo "Ya puedes proceder a insertar los datos de ejemplo en phpMyAdmin.";
} else {
    echo "<h1>Error</h1>";
    echo "Error creando la tabla: " . $conn->error . "<br>";
}

$conn->close();
?>