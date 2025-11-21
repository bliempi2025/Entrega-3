<?php
require 'conex.php';

echo "<h2>Iniciando reinicio de Base de Datos...</h2>";

// 1. ELIMINAR TABLAS ANTIGUAS (Orden inverso para evitar errores de llaves foraneas)
// Borramos speedruns primero porque depende de usuarios
$sql_drop_runs = "DROP TABLE IF EXISTS speedruns";
if ($conn->query($sql_drop_runs) === TRUE) {
    echo "<p>Tabla antigua 'speedruns' eliminada.</p>";
} else {
    echo "<p>Error borrando speedruns: " . $conn->error . "</p>";
}

// Borramos usuarios despues
$sql_drop_users = "DROP TABLE IF EXISTS usuarios";
if ($conn->query($sql_drop_users) === TRUE) {
    echo "<p>Tabla antigua 'usuarios' eliminada.</p>";
} else {
    echo "<p>Error borrando usuarios: " . $conn->error . "</p>";
}


// 2. CREAR TABLA USUARIOS (Con la columna 'nickname' correcta)
$sql_usuarios = "CREATE TABLE usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_usuarios) === TRUE) {
    echo "<p>Tabla 'usuarios' creada correctamente (con columna nickname).</p>";
} else {
    die("<p>Error fatal creando usuarios: " . $conn->error . "</p>");
}


// 3. CREAR TABLA SPEEDRUNS
$sql_speedruns = "CREATE TABLE speedruns (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    nickname VARCHAR(50) NOT NULL,
    game VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    time_record VARCHAR(20) NOT NULL,
    video_link VARCHAR(255) NOT NULL,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
)";

if ($conn->query($sql_speedruns) === TRUE) {
    echo "<p>Tabla 'speedruns' creada correctamente.</p>";
} else {
    die("<p>Error fatal creando speedruns: " . $conn->error . "</p>");
}

$conn->close();
echo "<h3>Base de datos reparada. Ya puedes registrarte.</h3>";
echo "<a href='register.php'>Ir a Registrarse</a>";
?>