<?php

require 'conex.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nickname = $_POST['nickname'];
    // Usamos MD5 según requisito de la pauta
    $password = md5($_POST['password']); 

    // Verificar si ya existe
    $check = $conn->prepare("SELECT id FROM usuarios WHERE nickname = ?");
    $check->bind_param("s", $nickname);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "El usuario ya existe.";
    } else {
        $sql = "INSERT INTO usuarios (nickname, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nickname, $password);

        if ($stmt->execute()) {
            $success = "¡Cuenta creada! Ahora puedes iniciar sesión.";
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Registro - SpeedRank</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-body-secondary">

    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-success">Crear Cuenta</h3>
            <p class="text-secondary">Únete a la comunidad</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
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
            <button type="submit" class="btn btn-success w-100 py-2">Registrarse</button>
        </form>

        <div class="text-center mt-3">
            <small>¿Ya tienes cuenta? <a href="login.php" class="text-decoration-none">Inicia sesión</a></small>
        </div>
    </div>

</body>
</html>