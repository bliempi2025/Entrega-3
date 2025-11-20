<?php
require 'conex.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nickname = $_POST['nickname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (nickname, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nickname, $password);

    if ($stmt->execute()) {
        $message = "Usuario registrado con éxito.";
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
</head>
<body>
    <h2>Crear cuenta</h2>

    <?php if ($message) echo "<p>$message</p>"; ?>

    <form method="POST">
        <label>Nickname:</label>
        <input type="text" name="nickname" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Registrarse</button>
    </form>

    <a href="login.php">Ya tengo cuenta</a>
</body>
</html>