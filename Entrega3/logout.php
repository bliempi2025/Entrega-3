<?php
// 1. Iniciar la sesión para poder acceder a ella
session_start();

// 2. Borrar todas las variables de sesión (user_id, nickname, etc.)
$_SESSION = array();

// 3. Destruir la sesión completamente en el servidor
session_destroy();

// 4. Redirigir al usuario a la página principal (ahora lo verá como visitante)
header("Location: index.php");
exit();
?>