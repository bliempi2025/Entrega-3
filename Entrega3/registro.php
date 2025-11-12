<?php
// inicia la sesion 
session_start();

// comprobamos si es que el usuario ya esta logueado 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // si ya esta entonces lo mandamos al index (pagina principal)
    header('location: index.php');
    exit;
}
?>

<!doctype html>

<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SpeedRank - Registro de Usuario</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card bg-body-tertiary rounded-3 shadow-sm p-4">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Registro en SpeedRank</h2>
                        
                        <form action="procesar_registro.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Registrarme</button>
                        </form>
                        
                        <p class="text-center mt-3">
                            ¿Ya tienes cuenta? <a href="login.php">Inicia Sesión</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>