<?php
/**
 * SETUP DEL PROYECTO
 * Crea todas las tablas necesarias para cumplir la Entrega 3:
 * - Tabla usuarios (para login/registro con MD5)
 * - Tabla speedruns (con user_id para CRUD y control de autor)
 */

require 'conex.php';

// =====================================
// 1. TABLA DE USUARIOS (login / sesiones)
// =====================================
$sql_usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,  -- Guardado en MD5
    email VARCHAR(100) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_usuarios) === TRUE) {
    echo "<p>✔ Tabla 'usuarios' lista.</p>";
} else {
    echo "<p> Error creando 'usuarios': " . $conn->error . "</p>";
}


// =====================================
// 2. TABLA SPEEDRUNS (CRUD completo)
// =====================================
$sql_speedruns = "CREATE TABLE IF NOT EXISTS speedruns (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,  -- Relación con usuarios
    nickname VARCHAR(50) NOT NULL,
    game VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    time_record VARCHAR(20) NOT NULL,
    video_link VARCHAR(255) NOT NULL,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Relación: solo el autor puede editar/eliminar
    FOREIGN KEY (user_id) REFERENCES usuarios(id)
    ON DELETE CASCADE
)";

if ($conn->query($sql_speedruns) === TRUE) {
    echo "<p>✔ Tabla 'speedruns' lista.</p>";
} else {
    echo "<p> Error creando 'speedruns': " . $conn->error . "</p>";
}

$conn->close();

echo "<h2>Setup completado con éxito 🎉</h2>";
?>