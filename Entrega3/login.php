<?php
session_start();
require 'conex.php';

$message = ""; // <--- Inicializamos la variable vacía para que no de error

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nickname = $_POST["nickname"];
    $password = $_POST["password"];
    
    // MD5 para cumplir pauta
    $password_md5 = md5($password); 

    $sql = "SELECT * FROM usuarios WHERE nickname = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ss", $nickname, $password_md5);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            $_SESSION["user"] = $user["nickname"];
            $_SESSION["user_id"] = $user["id"]; 
            
            header("Location: index.php");
            exit();
        } else {
            $message = "Usuario o contraseña incorrectos.";
        }
        $stmt->close();
    } else {
        $message = "Error en la consulta SQL.";
    }
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-body-secondary">
    
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">SpeedRank</h3>
            <p class="text-secondary">Bienvenido de nuevo</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-danger text-center"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nickname</label>
                <input type="text" name="nickname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Entrar</button>
        </form>
        <div class="text-center mt-3">
            <small>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></small>
        </div>
    </div>
</body>
</html>