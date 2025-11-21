<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedRank - Leaderboard</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php 
// Iniciar sesión al principio de todo
session_start(); 
?>

<script>
    const currentUserId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
</script>

<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="imagenes/logo.png" alt="Logo" style="width: 30px; margin-right: 10px;" onerror="this.style.display='none'">
                <strong>SpeedRank</strong>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (!isset($_SESSION['user'])): ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Registrarse</a></li>
                    <?php else: ?>
                        <li class="nav-item">
                            <span class="nav-link text-info">Hola, <b><?= htmlspecialchars($_SESSION['user']) ?></b></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="logout.php">Cerrar Sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container my-4">
    <div class="row g-4">
        
        <div class="col-lg-8">
            <section class="bg-body-tertiary p-4 rounded-4 shadow h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0 text-primary">Leaderboard Global</h2>
                    <button id="load-runs-btn" class="btn btn-sm btn-outline-primary">Refrescar</button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Juego / Categoría</th>
                                <th>Jugador</th>
                                <th>Tiempo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="leaderboard-body">
                            </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="col-lg-4">
            <section class="bg-body-tertiary p-4 rounded-4 shadow">
                <h3 class="mb-3">Subir Run</h3>
                
                <?php if (!isset($_SESSION['user'])): ?>
                    <div class="alert alert-warning border-warning">
                        <b>Inicia sesión</b> para participar y subir tus tiempos.
                    </div>
                    <a href="login.php" class="btn btn-primary w-100">Ir al Login</a>
                <?php else: ?>
                    <form id="submit-run-form">
                        <div class="mb-3">
                            <label class="form-label">Juego</label>
                            <input type="text" name="game" class="form-control bg-dark text-light border-secondary" placeholder="Ej: Super Mario 64" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <input type="text" name="category" class="form-control bg-dark text-light border-secondary" placeholder="Ej: Any% Glitchless" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tiempo</label>
                            <input type="text" name="time_record" class="form-control bg-dark text-light border-secondary" placeholder="HH:MM:SS" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Video URL</label>
                            <input type="url" name="video_link" class="form-control bg-dark text-light border-secondary" placeholder="https://youtube.com/..." required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold">
                            Publicar Récord
                        </button>
                    </form>
                <?php endif; ?>
            </section>
        </div>
    </div>
</main>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title">Editar Speedrun</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="edit-run-form">
            <input type="hidden" id="edit_id">
            
            <div class="mb-3">
                <label class="form-label">Juego</label>
                <input type="text" class="form-control bg-secondary text-white border-0" id="edit_game" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <input type="text" class="form-control bg-secondary text-white border-0" id="edit_category" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tiempo</label>
                <input type="text" class="form-control bg-secondary text-white border-0" id="edit_time" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Enlace del Video</label>
                <input type="url" class="form-control bg-secondary text-white border-0" id="edit_video" required>
            </div>
        </form>
      </div>
      <div class="modal-footer border-secondary">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="saveEdit()">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>

<footer class="mt-5 text-center text-muted py-3 border-top border-secondary">
    <small>&copy; 2025 SpeedRank - Proyecto de Desarrollo Web</small>
</footer>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>

</body>
</html>