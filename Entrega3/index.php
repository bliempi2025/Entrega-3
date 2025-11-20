<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedRank - Speedruns</title>

    <!-- Bootstrap CSS (REQUISITO de la pauta) -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- SweetAlert2 (Framework adicional) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Estilos propios -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php
// ============================
// SESIONES — Requisito de la pauta
// ============================
session_start();
?>

<header>
    <!-- ============================
         NAVBAR Bootstrap (comentado)
         ============================ -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom shadow-sm">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="imagenes/logo.png"
                     onerror="this.src='https://placehold.co/40x40/F0F/FFF?text=SR';"
                     style="width:40px" class="me-2">
                <strong>SpeedRank</strong>
            </a>

            <!-- Botón responsive -->
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navMenu" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">

                    <!-- Enlaces habituales -->
                    <li class="nav-item">
                        <a class="nav-link" href="#leaderboard">Leaderboard</a>
                    </li>

                    <?php if (!isset($_SESSION['user'])): ?>
                        <!-- Si NO hay sesión → mostrar Login / Registro -->
                        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar sesión</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Registrarse</a></li>
                    <?php else: ?>
                        <!-- Si hay sesión → mostrar nombre + logout -->
                        <li class="nav-item">
                            <span class="nav-link">Hola, <b><?= $_SESSION['user'] ?></b></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="logout.php">Cerrar sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </nav>
</header>

<main class="container my-4">

    <div id="notificaciones"></div>

    <div class="row g-4">

        <!-- =============================================
             COLUMNA IZQUIERDA — Leaderboard (READ)
             ============================================= -->
        <div class="col-lg-7">
            <section class="bg-body-tertiary p-4 rounded-4 shadow">

                <h2 class="mb-0">Leaderboard Global</h2>
                <p class="text-secondary">Runs registrados por los usuarios.</p>

                <!-- Botón para recargar tabla -->
                <button id="load-runs-btn" class="btn btn-primary mb-3">
                    Cargar / Refrescar Runs
                </button>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Juego</th>
                                <th>Jugador</th>
                                <th>Categoría</th>
                                <th>Tiempo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="leaderboard-body"></tbody>
                    </table>
                </div>

            </section>
        </div>

        <!-- =============================================
             COLUMNA DERECHA — Subir Run (CREATE)
             ============================================= -->
        <div class="col-lg-5">
            <section class="bg-body-tertiary p-4 rounded-4 shadow">

                <h2>Sube tu Speedrun</h2>
                <p class="text-secondary">Tu tiempo aparecerá en el leaderboard.</p>

                <?php if (!isset($_SESSION['user'])): ?>
                    <!-- Bloqueo cuando no hay sesión -->
                    <div class="alert alert-warning">
                        Debes iniciar sesión para subir un run.
                    </div>
                <?php endif; ?>

                <form id="submit-run-form" <?= !isset($_SESSION['user']) ? "class='opacity-50 pe-none'" : "" ?>>

                    <input type="hidden" id="run_id">

                    <div class="mb-3">
                        <label class="form-label">Tu Nickname:</label>
                        <input type="text" class="form-control" id="nickname" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Juego:</label>
                        <input type="text" class="form-control" id="game" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Categoría:</label>
                        <input type="text" class="form-control" id="category" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tiempo (HH:MM:SS):</label>
                        <input type="text" class="form-control" id="time_record" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link del video:</label>
                        <input type="url" class="form-control" id="video_link" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        Guardar Run
                    </button>
                </form>

            </section>
        </div>

    </div>

</main>

<!-- Bootstrap JS -->
<script src="js/bootstrap.bundle.min.js"></script>

<!-- Archivo JS del proyecto -->
<script src="script.js" defer></script>

</body>
</html>