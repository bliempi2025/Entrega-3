<?php
session_start();
require 'conex.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nickname = $_POST["nickname"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE nickname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
  
        if (password_verify($password, $user['password'])) {
            $_SESSION["user"] = $user["nickname"];
            header("Location: index.php");
            exit();
        } else {
            $message = "Contraseña incorrecta.";
        }
    } else {
        $message = "Usuario no encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
</head>
<body>
    <h2>Iniciar sesión</h2>

    <?php if ($message) echo "<p>$message</p>"; ?>

    <form method="POST">
        <label>Nickname:</label>
        <input type="text" name="nickname" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Entrar</button>
    </form>

    <a href="register.php">Crear cuenta</a>
</body>
</html>